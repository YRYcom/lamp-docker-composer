@extends('layouts.main')

@section('titleName', 'Opération - Ajouter')

@section('main')
<table>
    <tr>
        <th>{{ $annee }}</th>
        <th>Janvier</th>
        <th>Février</th>
        <th>Mars</th>
        <th>Avril</th>
        <th>Mai</th>
        <th>Juin</th>
        <th>Juillet</th>
        <th>Aout</th>
        <th>Septembre</th>
        <th>Octobre</th>
        <th>Novembre</th>
        <th>Décembre</th>
        <th>Total</th>
        <th>En attente</th>
        <th>Solde Réel</th>
    </tr>
    <tr>
        <td>
            Solde début de mois
        </td>
    </tr>
    <tr>
        <td>
            Recette
        </td>
    </tr>
    @foreach($recettes as $recette)
        <tr>
            <td>
                {{$recette->designation}}
            </td>
            @for ($mois=1; $mois <=12; $mois++)
                <td>
                    {{ $recette->getMontant($annee, $mois) }}
                </td>
            @endfor
            <td>
                {{ $recette->getMontant($annee) }}
            </td>
            <td>
                {{ $recette->getMontantAttente($annee) }}
            </td>
            <td>
                {{ $recette->getMontant($annee) + $recette->getMontantAttente($annee) }}
            </td>
        </tr>
    @endforeach
    <tr>
        <td>
            Total
        </td>
        @for($mois=1; $mois <=12; $mois++)
            <td>
                {{ $recettes->getMontant($annee, $mois) }}
            </td>
        @endfor
        <td>
            {{ $recettes->getMontant($annee) }}
        </td>
        <td>
            {{ $recettes->getMontantAttente($annee) }}
        </td>
        <td>
            {{ $recettes->getMontant($annee) + $recettes->getMontantAttente($annee) }}
        </td>
    </tr>
    <tr>
        <td colspan="16">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td>
            Dépense
        </td>
    </tr>
    @foreach($depenses as $depense)
        <tr>
            <td>
                {{$depense->designation}}
            </td>
            @for($mois=1; $mois <=12; $mois++)
                <td>
                    {{ $depense->getMontant($annee, $mois) }}
                </td>
            @endfor
            <td>
                {{ $depense->getMontant($annee) }}
            </td>
            <td>
                {{ $depense->getMontantAttente($annee) }}
            </td>
            <td>
                {{ $depense->getMontant($annee) + $depense->getMontantAttente($annee) }}
            </td>
        </tr>
    @endforeach
    <tr>
        <td>
            Total
        </td>
        @for($mois=1; $mois <=12; $mois++)
            <td>
                {{ $depenses->getMontant($annee, $mois) }}
            </td>
        @endfor
        <td>
            {{ $depenses->getMontant($annee) }}
        </td>
        <td>
            {{ $depenses->getMontantAttente($annee) }}
        </td>
        <td>
            {{ $depenses->getMontant($annee) + $depenses->getMontantAttente($annee) }}
        </td>
    </tr>
    <tr>
        <td colspan="16">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td>
            Résultat
        </td>
        @for($mois=1; $mois <=12; $mois++)
            <td>
                {{ $recettes->getMontant($annee, $mois) - $depenses->getMontant($annee, $mois) }}
            </td>
        @endfor
        <td>
            {{ $recettes->getMontant($annee) - $depenses->getMontant($annee) }}
        </td>
        <td>
            {{ $recettes->getMontantAttente($annee) - $depenses->getMontantAttente($annee) }}
        </td>
        <td>
            {{ $recettes->getMontant($annee) + $depenses->getMontantAttente($annee) - $depenses->getMontant($annee) - $depenses->getMontantAttente($annee) }}
        </td>
    </tr>
</table>
@endsection
