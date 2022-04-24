<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use File;

class ImportCompanyController extends Controller
{
    public function importPage(){
        return view('companies.importPage');
    }

    public function importData(Request $request){
        $request->validate([
            'fileName' => 'required',
        ]);
        $file = $request->file('fileName');
        $fileName = $file->getClientOriginalName();
        $renamedFileName = Date('Ymdhis').'_'.$fileName; //Renamed file name
              
        $extension = strtolower($file->getClientOriginalExtension());
        if (in_array($extension, array('csv')))
        { 
            if(!File::exists(storage_path().'/import-company')) {
                File::makeDirectory(storage_path().'/import-company', 0777, true, true);
            } 
            file_put_contents(storage_path().'/import-company/'.$renamedFileName, file_get_contents($file->getPathname()));
            $path = storage_path('import-company/'.$renamedFileName);
            $isExists = file_exists($path); /*Check File Exists*/
            if(!$isExists){
                //return response()->json(['success'=>false, 'message'=>'File is not uploaded' ,'data'=>[] ], 200);
            }
            //unlink($path); //After read csv unlink the file
            $arrCompany = $this->csvToArray($path,$request);
            //dd($arrCompany);
            if($arrCompany){
                return redirect()->route('companies.index')
                        ->with('success','Company created successfully.');
            }else{
                return redirect()->route('companies.index')
                        ->with('error','Something went wrong.');
            }
        }else{
            return redirect()->route('import-company')
                        ->with('error','Something went wrong.');
        }
    }


    /*Read csv file*/
    public function csvToArray($filename = '', $request)
    {
        echo $filename;
        $delimiter = ',';
        if (!file_exists($filename) || !is_readable($filename)){
            return false;
        }
        $header = null;
        $data = array();
        $error = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            
            $counter = 0;
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if($counter>0){
                    //dd($row);
                    $companyArr = array("name"=>$row[0],"email"=>$row[1],"website"=>$row[2]);
                    Company::create($companyArr); 
                }
                $counter++;
            }
            fclose($handle);
            return true;
        }
        
    }
    
}
