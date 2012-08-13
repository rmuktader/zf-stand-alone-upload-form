<?php
/**
 * @file form-contact.tpl.php
 */
?>
<!doctype html>  
<html lang="en">  
<head>  
<meta charset="utf-8">  
<title>Stand Alone Zend Form</title>  
<meta name="description" content="Stand Alone Zend Form">  
<meta name="author" content="Rayhan Muktader">  
<!--[if lt IE 9]>  
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>  
<![endif]-->  
</head>  
<body>  
      
    <form id="contact" action="<?= $this->element->getAction(); ?>" 
        method="<?= $this->element->getMethod(); ?>"
        enctype="<?= $this->element->getEnctype();?>">

        <table>
            <tr>
                <td>Upload File:</td>
                <td><?= $this->element->file; ?></td>
            </tr>

            <tr>
                <td>Message:</td>
                <td><?= $this->element->message; ?></td>
            </tr>
            
            <tr>
                <td><?= $this->element->submit ?></td>
            </tr>
        </table>
    </form>
    
</body>  
</html>  