@extends('layouts.main')

@section('titleName',  $compteBancaire->entreprise->designation . ' - Trésorerie : ' . $compteBancaire->designation  )

@section('css')
    <style>
        tr[data-toggle="collapse"] {
            cursor: pointer;
        }
        tr.collapse-id  {
            color: #212529;
            background-color: rgba(0,0,0,.040);
        }
        tr.collapse-id {
            font-style: italic;
        }
    </style>
@endsection

@section('main')
<table class="table table-bordered table-hover text-nowrap">
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
        <td class="font-weight-bold" >
            Solde début de mois
        </td>
        @for ($mois=1; $mois <=12; $mois++)
            <td class="text-right">
                {{  monetaire($compteBancaire->soldeDebutMois($annee, $mois) ) }}
            </td>
        @endfor
        <td> - </td>
        <td> - </td>
        <td> - </td>
    </tr>
    <tr>
        <td class="font-weight-bold" colspan="16">
            Recette
        </td>
    </tr>
    @foreach($recettes as $recette)
        <tr>
            <td>
                {{$recette->designation}}
            </td>
            @for ($mois=1; $mois <=12; $mois++)
                <td class="text-right">
                    {{  monetaire($recette->getMontant($annee, $mois) ) }}
                </td>
            @endfor
            <td class="text-right">
                {{ monetaire($recette->getMontant($annee) ) }}
            </td>
            <td class="text-right">
                {{ monetaire($recette->getMontantAttente($annee) ) }}
            </td>
            <td class="text-right">
                {{ monetaire($recette->getMontant($annee) + $recette->getMontantAttente($annee) ) }}
            </td>
        </tr>
    @endforeach
    <tr>
        <td class="font-weight-bold" >
            Total
        </td>
        @for($mois=1; $mois <=12; $mois++)
            <td class="text-right">
                {{ monetaire($recettes->getMontant($annee, $mois) ) }}
            </td>
        @endfor
        <td class="text-right">
            {{ monetaire($recettes->getMontant($annee) ) }}
        </td>
        <td class="text-right">
            {{ monetaire($recettes->getMontantAttente($annee) ) }}
        </td>
        <td class="text-right">
            {{ monetaire($recettes->getMontant($annee) + $recettes->getMontantAttente($annee) ) }}
        </td>
    </tr>
    <tr>
        <td colspan="16">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td class="font-weight-bold"  colspan="16">
            Dépense
        </td>
    </tr>
    @foreach($depenses as $depense)
        <tr data-toggle="collapse" data-target=".collapse-{{ $depense->id }}" aria-expanded="false">
            <td>
                {{$depense->designation}}
            </td>
            @for($mois=1; $mois <=12; $mois++)
                <td class="text-right">
                    {{ monetaire($depense->getMontant($annee, $mois) )}}
                </td>
            @endfor
            <td class="text-right">
                {{ monetaire($depense->getMontant($annee) ) }}
            </td>
            <td class="text-right">
                {{ monetaire($depense->getMontantAttente($annee) ) }}
            </td>
            <td class="text-right">
                {{ monetaire(($depense->getMontant($annee) + $depense->getMontantAttente($annee)) )  }}
            </td>
        </tr>
        @foreach($depense->categories as $categorie)
        <tr class="collapse collapse-id collapse-{{ $depense->id }}">
            <td class="text-right">
                {{$categorie->designation}}
            </td>
            @for($mois=1; $mois <=12; $mois++)
                <td class="text-right">
                    {{ monetaire(($categorie->getMontant($annee, $mois) * -1 ) )}}
                </td>
            @endfor
            <td class="text-right">
                {{ monetaire(($categorie->getMontant($annee) * -1 ) ) }}
            </td>
            <td class="text-right">
                {{ monetaire(($categorie->getMontantAttente($annee)  * -1 ))  }}
            </td>
            <td class="text-right">
                {{ monetaire(((($categorie->getMontant($annee) + $categorie->getMontantAttente($annee))) * -1 ) )  }}
            </td>
        </tr>
        @endforeach
    @endforeach
    <tr>
        <td class="font-weight-bold" >
            Total
        </td>
        @for($mois=1; $mois <=12; $mois++)
            <td class="text-right">
                {{ monetaire($depenses->getMontant($annee, $mois) ) }}
            </td>
        @endfor
        <td class="text-right">
            {{ monetaire($depenses->getMontant($annee) ) }}
        </td>
        <td class="text-right">
            {{ monetaire($depenses->getMontantAttente($annee) ) }}
        </td>
        <td class="text-right">
            {{ monetaire(($depenses->getMontant($annee) + $depenses->getMontantAttente($annee)) ) }}
        </td>
    </tr>
    <tr>
        <td colspan="16">
            &nbsp;
        </td>
    </tr>
    <tr>
        <td class="font-weight-bold" >
            Résultat
        </td>
        @for($mois=1; $mois <=12; $mois++)
            <td class="text-right">
                {{ monetaire(($recettes->getMontant($annee, $mois) - $depenses->getMontant($annee, $mois)) ) }}
            </td>
        @endfor
        <td class="text-right">
            {{ monetaire(($recettes->getMontant($annee) - $depenses->getMontant($annee)) ) }}
        </td>
        <td class="text-right">
            {{ monetaire(($recettes->getMontantAttente($annee) - $depenses->getMontantAttente($annee)) ) }}
        </td>
        <td class="text-right">
            {{ monetaire(($recettes->getMontant($annee) + $recettes->getMontantAttente($annee) - $depenses->getMontant($annee) - $depenses->getMontantAttente($annee)) ) }}
        </td>
    </tr>
</table>
@endsection
