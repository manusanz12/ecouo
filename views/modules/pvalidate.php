<?PHP
class Pvalidate{


    static public function Validatemodule($pvalidate){
        $Validatemodule=json_decode($_SESSION["validates"]->module_role,true);
        
        foreach ($Validatemodule as $value) {

            if($value[0] == $pvalidate){

                $module_validate = "checked";
                return $module_validate;

            }
         }


    

    }

    static public function Validatepermit($pvalidate,$permisos){
        $Validatepermit=json_decode($permisos,true);

        
        
        foreach ($Validatepermit as $value) {
            
            if($value[0] == $pvalidate){

                $permit_validate = "checked";
                return $permit_validate;

            }
         }


    

    }

}
?>