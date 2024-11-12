CREATE OR REPLACE VIEW v_besoins_talent AS
SELECT
    a.id AS id_annonce,
    bp.id,
    p.id AS id_poste,
    p.libelle AS poste,
    d.id AS id_departement,
    d.libelle AS departement,
    pr.libelle AS urgence,
    bp.finValidite AS date_requis,
    bp.status AS status
FROM
    postes_depart pd
LEFT JOIN
    postes p ON pd.id_poste = p.id
LEFT JOIN
    departement d ON pd.id_departement = d.id
JOIN
    besoin_poste bp ON pd.id_poste = bp.id_poste
LEFT JOIN
    priorite pr ON bp.priorite = pr.id
LEFT JOIN
    annonce a ON bp.id = a.id_besoin_poste
WHERE
    (a.id IS NULL OR a.is_validate = false);


CREATE OR REPLACE VIEW v_besoins_talent_not_annonce AS
SELECT
    a.id AS id_annonce,
    bp.id,
    p.id AS id_poste,
    p.libelle AS poste,
    d.id AS id_departement,
    d.libelle AS departement,
    pr.libelle AS urgence,
    bp.finValidite AS date_requis,
    bp.status AS status
FROM
    postes_depart pd
LEFT JOIN
    postes p ON pd.id_poste = p.id
LEFT JOIN
    departement d ON pd.id_departement = d.id
LEFT JOIN
    besoin_poste bp ON pd.id_poste = bp.id_poste
LEFT JOIN
    priorite pr ON bp.priorite = pr.id
LEFT JOIN
    annonce a ON bp.id = a.id_besoin_poste;


CREATE OR REPLACE VIEW v_get_annonce AS
SELECT
a.id AS id_annonce,
bt.id,
bt.id_poste,
bt.poste,
bt.id_departement,
bt.departement,
bt.urgence,
bt.date_requis,
bt.status
FROM v_besoins_talent_not_annonce bt
JOIN annonce a ON bt.id = a.id_besoin_poste;




CREATE OR REPLACE VIEW v_getplublicite AS
SELECT
comm.libelle AS moyen_comm,
ac.date AS date_publicite,
bt.departement,
bt.poste
FROM annonce_communication ac
LEFT JOIN moyenne_comm comm ON ac.id_moyenne_comm = comm.id
LEFT JOIN annonce a ON ac.id_annonce = a.id
LEFT JOIN v_besoins_talent bt ON a.id_besoin_poste = bt.id;


CREATE OR REPLACE VIEW v_liste_personnel AS
SELECT
    e.id AS id_employe,
    e.date AS date_embauche,
    d.libelle AS departement,
    p.libelle AS poste,
    cc.date_debut AS date_debut_contrat,
    cc.salaire_propose AS salaire_propose,
    dos.candidat AS candidat,
    dos.email AS email_candidat,
    dos.statut AS statut_candidat,
    cv.status AS status_cv,
    cv.test AS note_test,
    cv.entretien AS statut_entretien,
    cv.comparaisonValider AS comparaison_validee,
    cont.libelle AS type_contrat,
    manager_dos.candidat AS nom_manager,
    manager_dos.email AS email_manager
FROM employe e
LEFT JOIN departement d ON e.id_departement = d.id
LEFT JOIN postes p ON e.id_poste = p.id
LEFT JOIN cv cv ON e.id_cv = cv.id
LEFT JOIN contrat cont ON e.id_contrat = cont.id
LEFT JOIN contrat_cv cc ON cv.id = cc.id_cv
LEFT JOIN dossiers dos ON cv.id_dossier = dos.id
LEFT JOIN departement_manager dm ON d.id = dm.id_departement
LEFT JOIN employe manager ON dm.id_employe = manager.id
LEFT JOIN cv manager_cv ON manager.id_cv = manager_cv.id
LEFT JOIN dossiers manager_dos ON manager_cv.id_dossier = manager_dos.id;



CREATE OR REPLACE VIEW v_liste_promotions AS
SELECT
    p.id AS id_promotion,
    vp.id_employe,
    vp.candidat AS nom_employe,
    vp.email_candidat AS email_employe,
    vp.departement AS departement_actuel,
    vp.poste AS poste_actuel,
    vp.salaire_propose AS salaire_actuel,
    p.date AS date_promotion,
    np.libelle AS nouveau_poste,
    p.salaire AS nouveau_salaire,
    p.status AS statut_promotion,
    vp.nom_manager AS manager,
    vp.email_manager AS email_manager
FROM v_liste_personnel vp
JOIN promotion p ON vp.id_employe = p.id_employe
LEFT JOIN postes np ON p.id_poste = np.id
ORDER BY p.date DESC;


CREATE OR REPLACE VIEW v_data_cv AS
SELECT
    cv.id AS id_cv,
    dos.candidat AS candidat,
    dos.email AS email_candidat,
    dos.lettre_motivation,
    cv.status AS status,
    cv.notes AS notes,
    cv.entretien AS entretien,
    cv.comparaisonValider AS comparaison_validee
FROM cv cv
LEFT JOIN dossiers dos ON cv.id_dossier = dos.id;


CREATE OR REPLACE VIEW v_valide_entretient AS
SELECT
    cv.id AS id_cv,
    ds.candidat,
    bp.id,
    p.id AS id_poste,
    p.libelle AS poste,
    d.id AS id_departement,
    d.libelle AS departement,
    e.date_entretien,
    MAX(ccv.id_contrat) AS id_contrat
FROM
    postes_depart pd
LEFT JOIN
    postes p ON pd.id_poste = p.id
LEFT JOIN
    departement d ON pd.id_departement = d.id
LEFT JOIN
    besoin_poste bp ON pd.id_poste = bp.id_poste
LEFT JOIN
    priorite pr ON bp.priorite = pr.id
LEFT JOIN
    dossiers ds ON bp.id = ds.id_besoin_poste
LEFT JOIN
    cv cv ON ds.id = cv.id_dossier
LEFT JOIN
    entretien e ON cv.id = e.id_cv
LEFT JOIN
    contrat_cv ccv ON cv.id = ccv.id_cv
WHERE
    (e.status = 'valide')

GROUP BY
    cv.id,
    ds.candidat,
    bp.id,
    p.id,
    p.libelle,
    d.id,
    d.libelle,
    e.date_entretien;



CREATE OR REPLACE PROCEDURE inserer_donnees_employe()
LANGUAGE plpgsql
AS
$$
BEGIN
    INSERT INTO employe (id_cv, id_departement, id_poste, date, id_contrat)
    SELECT
        id_cv,
        id_departement,
        id_poste,
        date_entretien AS date,
        id_contrat
    FROM
        v_valide_entretient;
END;
$$;


CALL inserer_donnees_employe();

\
    CREATE OR REPLACE VIEW v_contrats_cv_expiration AS
    SELECT
        c.id,
        c.libelle as contrat,
        date_debut + (periode * INTERVAL '1 month') AS date_expiration,
        d.candidat
    FROM contrat_cv ccv
    JOIN cv ON cv.id = ccv.id_cv
    JOIN dossiers d ON d.id = cv.id_dossier
    join contrat c on c.id = ccv.id_contrat
    ORDER BY ccv.id;

-- Pour tester la vue :
-- SELECT * FROM v_contrats_cv_expiration;

-- Pour voir uniquement les colonnes principales avec la date d'expiration :
-- SELECT id, id_cv, id_contrat, date_debut, periode, date_expiration, salaire_propose, notes_sup
-- FROM v_contrats_cv_expiration;
