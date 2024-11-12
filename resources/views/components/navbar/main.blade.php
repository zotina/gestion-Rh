@php $active = $active ?? ''; @endphp

<div class="fx__navbar shadow">
    <div class="fx__navbar-brand"> <h1> <a href="/"> Kopetrart </a></h1> </div>

    <div class="fx__navbar-section">
        <h3 class="fx__navbar-subtitle"> Général </h3>
        <ul class="fx__navbar-list">
            <x-navbar.item href="/exercice" :active="$active"> <i class="fa-solid fa-table"></i> Ecriture </x-navbar.item>
            <x-navbar.item href="/expense" :active="$active"> <i class="fa-solid fa-table"></i> Charge </x-navbar.item>
        </ul>
    </div>

    <div class="fx__navbar-section">
        <h3 class="fx__navbar-subtitle"> Coûts </h3>
        <ul class="fx__navbar-list">
            <x-navbar.item href="/cost/expense" :active="$active"> <i class="fa-solid fa-table"></i> Coût Unitaire Charge </x-navbar.item>
            <x-navbar.item href="/cost/product" :active="$active"> <i class="fa-solid fa-cash-register"></i> Coût Unitaire Produit </x-navbar.item>
            <x-navbar.item href="/cost/center/detail" :active="$active"> <i class="fa-solid fa-cash-register"></i> Coût Géneral par Centre </x-navbar.item>
            <x-navbar.item href="/cost/center/shared" :active="$active"> <i class="fa-solid fa-cash-register"></i> Répartition des Coûts </x-navbar.item>
        </ul>
    </div>

    <div class="fx__navbar-section">
        <h3 class="fx__navbar-subtitle"> Autre </h3>
        <ul class="fx__navbar-list">
            <x-navbar.item href="/section" :active="$active"> <i class="fa-solid fa-table"></i> Rubrique </x-navbar.item>
            <x-navbar.item href="/unit" :active="$active"> <i class="fa-solid fa-table"></i> Unité d'oeuvre </x-navbar.item>
            <x-navbar.item href="/center" :active="$active"> <i class="fa-solid fa-table"></i> Centre </x-navbar.item>
            <x-navbar.item href="/product" :active="$active"> <i class="fa-solid fa-table"></i> Produit </x-navbar.item>
        </ul>
    </div>
</div>
