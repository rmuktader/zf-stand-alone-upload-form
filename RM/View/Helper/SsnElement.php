<?php
/**
 * This class serves as the view for the custom element Ssn.
 * Much of its functionality comes from the parent class 
 * Zend_View_Helper_FormElement.
 * A method that matches the class name must be present with 
 * the right method signature.
 *
 * This element will produce composite element.
 *
 * @author Rayhan Muktader <rmuktader@gmail.com>
 */
class RM_View_Helper_SsnElement
    extends Zend_View_Helper_FormElement
{
     /**
      * @var string $_xhtml. will contain the rendered form element.
      */
    protected $_xhtml = '';
    
    /**
     * @param string $name the name of the form element.
     * @param string $value the value of the form element.
     * @param array $arrtibs the attribs for the form element.
     * @return string $_xhtml the rendered xhtml for this form element.
     */
    public function ssnElement( $name, $value = null, $attribs = null )
    { 
        // take the incoming SSN string break it up into three pieces for the
        // three elements that will make the composite element.
        $areanum = $groupnum = $serialnum = '';
        if ( $value ) { 
            $areanum   = substr( $value, 0 , 3 );
            $groupnum  = substr( $value, 3 , 2 );
            $serialnum = substr( $value, 5 , 4 );
        }
        
        // Use Zend_View_Helper_FormText to build the elements that will form
        // the composite element.
        $helper = new Zend_View_Helper_FormText();
        
        // Must assign a view since we are outside zend's normal MVC structure.
        $helper->setView( $this->view );

        
        // Create the xhtml
        $this->_xhtml .= $helper->formText( 
            $name . '[areanum]', 
            $areanum, 
            array( 'size'=>3, 'maxlength'=>3 ) 
        );
            
        $this->_xhtml .= $helper->formText( 
            $name . '[groupnum]', 
            $groupnum, 
            array( 'size'=>2, 'maxlength'=>2 ) 
        );
            
        $this->_xhtml .= $helper->formText( 
            $name . '[serialnum]', 
            $serialnum, 
            array( 'size'=>4, 'maxlength'=>4 ) 
        );
        
        return $this->_xhtml;
    }
}