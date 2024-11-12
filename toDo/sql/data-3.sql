-- CONSTANTS
INSERT INTO test_candidate_result(label) VALUES('Valide');
INSERT INTO test_candidate_result(label) VALUES('Echec');
INSERT INTO test_candidate_result(label) VALUES('En Attente');

INSERT INTO test_point_importance(label) VALUES('Blocant');
INSERT INTO test_point_importance(label) VALUES('Important');
INSERT INTO test_point_importance(label) VALUES('Bonus');

-- TEST
INSERT INTO candidate(first_name, last_name, email) VALUES ('John', 'Doe', 'john@gmail.com');
INSERT INTO candidate(first_name, last_name, email) VALUES ('Jane', 'Smith', 'jane@gmail.com');

INSERT INTO need(title, description) VALUES('Backend Developer', 'Backend Developer Description');
INSERT INTO need(title, description) VALUES('Frontend Developer', 'Frontend Developer Description');

INSERT INTO cv_candidate(id_candidate, id_need, date_received, file) VALUES ( 1, 1, '2024-01-01', '');
INSERT INTO cv_candidate(id_candidate, id_need, date_received, file) VALUES ( 2, 2, '2024-01-01', '');

INSERT INTO test(id_need, title, objectif, requierements) VALUES(1, 'Backend Developer Test', 'Some Objectives', 'Some Requirement');

INSERT INTO test_candidate(id_test, id_cv_candidate, date_received, file, id_result) VALUES (1, 1, '2024-02-01', '', 3);
INSERT INTO test_candidate(id_test, id_cv_candidate, date_received, file, id_result) VALUES (1, 2, '2024-02-01', '', 3);
