<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>recrutements</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicons -->

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fonts/fontawesome-all.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/template.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/table.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/formulaire.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/pagination.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="/lib/fa/css/all.min.css" />

        <link rel="stylesheet" type="text/css" href="/lib/toolkit/css/chart.toolkit.css" />
        <link rel="stylesheet" type="text/css" href="/lib/mdb5/css/mdb.min.css" />

        <script type="text/javascript" src="/lib/toolkit/js/chart.umd.js" defer></script>
        <script type="text/javascript" src="/lib/toolkit/js/chart.toolkit.js" defer></script>

        <script type="text/javascript" src="/lib/mdb5/js/mdb.umd.min.js" defer></script>
        @stack('styles')
    <!-- =======================================================
    * Template Name: NiceAdmin - v2.5.0
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->

</head>
<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <meta charset="UTF-8">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ url('index.html') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/logo.png') }}" alt="">
                <span class="d-none d-lg-block"></span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>

        </div><!-- End Logo -->

    </header><!-- End Header -->
    <style>
        .session-info {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.session-info p {
    margin: 0;
    padding: 5px 0;
    font-size: 14px;
    color: #6c757d;
}

.session-info span {
    font-weight: 600;
    color: #4154f1;
    background: #e0e3ff;
    padding: 3px 8px;
    border-radius: 4px;
    margin-left: 5px;
}

.role-id {
    border-bottom: 1px solid #dee2e6;
}

.role-name {
    margin-top: 5px;
}

/* Style spécifique selon le rôle */
.session-info[data-role="1"] span {
    background: #e1f6ff;
    color: #0dcaf0;
}

.session-info[data-role="2"] span {
    background: #e1ffe1;
    color: #198754;
}

.session-info[data-role="3"] span {
    background: #fff3cd;
    color: #ffc107;
}

.session-info[data-role="4"] span {
    background: #ffe1e1;
    color: #dc3545;
}

.session-info[data-role="5"] span {
    background: #e1e1ff;
    color: #6610f2;
}
    </style>
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-heading">dashboard sur le recrutements</li>
            <!-- Remplacez la ligne existante par -->
                @php
                $session = session();
                @endphp
                <div class="session-info">
                    <p class="role-name"><span>{{ session('role_name') }}</span></p>
                </div>

            <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#besoin_poste-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-menu-button-wide"></i><span>Besoin en Talent</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="besoin_poste-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ url('besoin_poste') }}">
                                <i class="bi bi-circle"></i><span>Besoin_poste</span>
                            </a>
                        </li>
                        @if ($session->get('role') == 2) <!-- Vérifiez si le rôle est 'PDG' -->

                        <li>
                            <a href="{{ url('besoin_poste/create') }}">
                                <i class="bi bi-circle"></i><span>Form Besoins Poste</span>
                            </a>
                        </li>
                        @endif

                    </ul>
                </li>



            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#employe-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Employe</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="employe-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ url('employe') }}">
                            <i class="bi bi-circle"></i><span>Employe</span>
                        </a>
                    </li>
                </ul>
            </li>
            @if ($session->get('role') == 3 || $session->get('role') == 1) <!-- Vérifiez si le rôle est 'PDG' -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#promotion-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Promotion</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="promotion-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="{{ url('promotion') }}">
                            <i class="bi bi-circle"></i><span>Liste Promotion</span>
                        </a>
                    </li>

                </ul>
            </li>

            @endif

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#dossiers-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Dossiers</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="dossiers-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ url('dossiers') }}">
                            <i class="bi bi-circle"></i><span>Dossiers</span>
                        </a>
                    </li>

                    @if ($session->get('role') == 5)
                    <li>
                        <a href="{{ url('dossiers/create') }}">
                            <i class="bi bi-circle"></i><span>Ajout</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>

            @if ($session->get('role') == 5 || $session->get('role') == 2)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#cv-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Cv</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="cv-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ url('cv') }}">
                            <i class="bi bi-circle"></i><span>Cv</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            @if ($session->get('role') == 4 || $session->get('role') == 2)
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#entretien-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Entretien</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="entretien-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ url('entretien') }}">
                            <i class="bi bi-circle"></i><span>Entretien</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if ($session->get('role') == 2 || $session->get('role') == 5 || ($session->get('role') == 3) || $session->get('role') == 4 )
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#test-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Test</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="test-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    @if ($session->get('role') == 3)
                    <li>
                        <a href="{{ url('test/create') }}">
                            <i class="bi bi-circle"></i><span>Questionnaire</span>
                        </a>
                    </li>
                    @endif

                    @if ($session->get('role') == 2 || $session->get('role') == 4)
                    <li>
                        <a href="{{ url('test-candidate') }}">
                            <i class="bi bi-circle"></i><span>Test Candidat</span>
                        </a>
                    </li>
                    @endif



                </ul>
            </li>
            @endif
            @if ($session->get('role') == 2)

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#contrat-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Contrat</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="contrat-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ url('contrat') }}">
                            <i class="bi bi-circle"></i><span>Listes des contrats</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('contrat/showEssaiForm') }}">
                            <i class="bi bi-circle"></i><span>Essai</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if ($session->get('role') == 4)

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#annonce-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Annonce</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="annonce-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ url('annonce') }}">
                            <i class="bi bi-circle"></i><span>Annonce</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('publicite') }}">
                            <i class="bi bi-circle"></i><span>Publicite</span>
                        </a>
                    </li>
                </ul>
            </li>

            @endif

            <div class="dropdown">
                <li>
                    <a style="display: block; padding: 8px; color:red" href="{{ url('logout') }}">
                        <i class="fa fa-sign-out" style="margin-right: 3.6px; color:red"></i>
                        <span>Logout</span>
                    </a>


                </li>
            </div>
        </ul>

    </aside><!-- End Sidebar -->
    <main id="main" class="main">
        @yield('content')
    </main><!-- End Main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
  <div class="copyright">
    &copy; Copyright <strong><span>ETU-2597</span></strong>. All Rights Reserved
  </div>
  <div class="credits">
    <!-- All the links in the footer should remain intact. -->
    <!-- You can delete the links only if you purchased the pro version. -->
    <!-- Licensing information: https://bootstrapmade.com/license/ -->
    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
  </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/js/main1.js') }}"></script>
@stack('scripts')

</body>
</html>
