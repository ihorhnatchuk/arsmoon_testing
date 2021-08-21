<?php 
namespace App\Service\Upload;


class UploadCsvService
{
    public static function execute(string $fileName): array
    {
        $csv = array();

        // check there are no errors
        if($_FILES[$fileName]['error'] == 0){
            $name = $_FILES[$fileName]['name'];
            $tmp = explode('.', $name);
            $ext = end($tmp);
            $tmpName = $_FILES[$fileName]['tmp_name'];

            // check the file is a csv
            if($ext === 'csv'){
                if(($handle = fopen($tmpName, 'r')) !== FALSE) {
                    // necessary if a large csv file
                    set_time_limit(0);

                    $row = 0;

                    while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        // number of fields in the csv
                        $col_count = count($data);

                        // get the values from the csv
                        $csv[$row]['costomer_id'] = $data[0];
                        $csv[$row]['date_time'] = $data[1];
                        $csv[$row]['seconds'] = (int) $data[2];
                        $csv[$row]['phone'] = $data[3];
                        $csv[$row]['ip'] = $data[4];

                        // inc the row
                        $row++;
                    }
                    fclose($handle);
                }
            }
        }

        return $csv;
    }

}