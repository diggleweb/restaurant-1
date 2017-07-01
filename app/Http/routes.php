<?php
Route::get('/excell', function(){

\Excel::create('file', function($excel) {
            // require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
            // require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/Cell/DataValidation.php");

            $excel->sheet('New sheet', function($sheet) {

                $sheet->SetCellValue("A1", "UK");
                $sheet->SetCellValue("A2", "USA");

                $sheet->_parent->addNamedRange(
                        new \PHPExcel_NamedRange(
                        'countries', $sheet, 'A1:A2'
                        )
                );


                $sheet->SetCellValue("B1", "London");
                $sheet->SetCellValue("B2", "Birmingham");
                $sheet->SetCellValue("B3", "Leeds");
                $sheet->_parent->addNamedRange(
                        new \PHPExcel_NamedRange(
                        'UK', $sheet, 'B1:B3'
                        )
                );

                $sheet->SetCellValue("C1", "Atlanta");
                $sheet->SetCellValue("C2", "New York");
                $sheet->SetCellValue("C3", "Los Angeles");
                $sheet->_parent->addNamedRange(
                        new \PHPExcel_NamedRange(
                        'USA', $sheet, 'C1:C3'
                        )
                );
                $objValidation = $sheet->getCell('D1')->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1('countries'); //note this!
            });
        })->download("xlsx");
        return view('home');
	return File::get(public_path() . '/index.html');
});