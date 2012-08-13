<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
/**
 * @file form.php
 */
 
// Load Zend Framework
set_include_path(
        implode(PATH_SEPARATOR, array(
                get_include_path(),
                __DIR__ .'/'
        ))
);
        
// Create the auto loader so zend can load the rest automatically
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();

$form = new Zend_Form;

// Set form name, id, method and action
$form->setName( 'fileUpload' )
    ->setAttrib( 'id', 'fileUpload' )
    ->setMethod( 'post' )
    ->setAttrib('enctype', 'multipart/form-data')
    ->setAction( 'http://'.
        $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] 
    );
    
$file = new Zend_Form_Element_File('file');
        $file->setLabel('File')
            ->setRequired(true)
            //do not save file when getValues() is called
            ->setValueDisabled(False)
            ->addValidator('Extension', FALSE, 'jpg,jpeg')
            ->addValidator(
                'Size', 
                false, 
                array( 'min' => 20, 'max' => 20000000 ) // 2MB
            );
             
$file->getValidator('Extension')->setMessage( 'JPEGs only' );             
            
// Create text area for message    
$message = new Zend_Form_Element_Textarea( 'message' );
$message->setRequired( TRUE )
    ->setAttrib( 'id', 'message' )
    ->addErrorMessage( 'Please specify a message' );

// Create a submit button    
$submit = new Zend_Form_Element_Submit( 'submit' );
$submit->setLabel( 'Submit' )
    ->setAttrib( 'id', 'submit' );

// Set the ViewScript decorator for the form and tell it which 
// template file to use
$form->setDecorators( array( 
    array( 'ViewScript', array( 'viewScript' => 'form-contact.tpl.php' ) ) ) );

// Add the form elements AFTER the viewscript decorator has been set
$form->addElements( array( $file, $message, $submit ) );

// Get rid of all element decorators except for ViewHelper to render
// the individual elements and Errors decorator to render the errors.
$form->setElementDecorators( array( 'ViewHelper', 'Errors' ) );

 

// The file element requires the File decorator instead of the 
// ViewHelper decorator
$file->setDecorators( array( 'File', 'Errors' ) ); 
 
// Create an instance of Zend_View and set the directory 
// for the template files
$view = new Zend_View();
$view->setScriptPath( __DIR__ );

// Tell all the elements in the form which view to use when rendering
foreach ($form as $item){
    $item->setView($view);
}



// process or display the form
if( isset( $_POST['submit'] ) && ( $form->isValid( $_POST ) ) ) {


    $uploadHandler = new Zend_File_Transfer_Adapter_Http();
    $uploadHandler->setDestination( __DIR__ .'/uploads/' );
    try {
        $uploadHandler->receive();
        
        $data = $form->getValues();
        Zend_Debug::dump($data, 'Form Data:');
        
        $fullPath = $uploadHandler->getFileName( 'file' );

        $size = $uploadHandler->getFileSize( 'file' );
        
        $mimeType = $uploadHandler->getMimeType( 'file' );
        
        $fileInfo = pathinfo( $fullPath );
        
        
        $name =  $fileInfo['basename'] . '<br>';
        
        
        // rename the file for security purpose
        $newName = 'RM_' . time() . '_' . $fileInfo['basename'] ;

        $fullFilePath = __DIR__ .'/uploads/'.$newName;

        
        $filterFileRename = new Zend_Filter_File_Rename(
            array('target' => $fullFilePath, 'overwrite' => true)
        );

        $filterFileRename -> filter($fullPath);

        
        echo 'thanks <br />';
    } catch ( Zend_File_Transfer_Exception $e ) {
        echo $e->getMessage();
    }
    
    
} else {
    echo $form->render( $view );
}