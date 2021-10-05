<?php
namespace App\Console\Commands;

use App\Models\CompteBancaire;
use App\Models\DocumentOperation;
use App\Models\Entreprise;
use App\Models\Operation;
use App\Models\OperationExport;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportYRYcomCreditAgricole2021 extends Command
{
    /**
     * @var string
     */
    protected $signature = 'import:yrycomca2021';

    protected $annee = 2021;
    protected $compte_bancaire_id = 1;

    /**
     * @var string
     */
    protected $description = 'Import trésorerie YRYcom Crédit Agricole 2021';

    public function handle(): void
    {
        $compteBancaire = CompteBancaire::find($this->compte_bancaire_id);
        $user = Entreprise::find($compteBancaire->entreprise)->first()->users->first();

        $file = fopen( Storage::disk('importoperation')->path('yrycomca2021.csv') , "r");
        $entete = true;
        while ( ($data = fgetcsv($file, 200, ",")) !== FALSE) {
            if($entete === true) {
                $entete=false;
                continue;
            }

            if(strpos($data[0], '-')) {
                list($day, $month) = explode('-',$data[0]);
                switch($month) {
                    case 'juin':
                        $month=6;
                        break;
                    case 'juil.':
                        $month=7;
                        break;
                }
            } else {
                list($day, $month) = explode('/',$data[0]);
            }



            $extension = \File::extension($data[4]);
            if($extension == ''){
                $data[4] .= '.pdf';
            }

            $export = new OperationExport([
                'compte_bancaire_id' => $compteBancaire->id,
                'created_by' => $user->id,
            ]);
            $export->setDefaultDesignation();
            $export->save();

            $operation = new Operation([
                'designation' => $data[1],
                'categorie_id' => $data[5],
                'date_realisation' => \DateTime::createFromFormat('Y-m-d', $this->annee.'-'.$month.'-'.$day),
                'credit' => (float) str_replace(',', '.', $data[3]),
                'debit' => (float)str_replace(',', '.', $data[2]),
                'pointe' => 1,
                'sans_justificatif' => $data[4] == '-' ? 1 : 0,
                'user_id' => $user->id,
                'compte_bancaire_id' => $compteBancaire->id,
                'operation_export_id' => $export->id,
            ]);
            $operation->save();

            $documentOperation = new DocumentOperation([
                'original_filename' => $data[4],
                'filename' => 'import.pdf',
                'operation_id' => $operation->id,
            ]);
            $documentOperation->save();

        }
        fclose($file);

    }

}
