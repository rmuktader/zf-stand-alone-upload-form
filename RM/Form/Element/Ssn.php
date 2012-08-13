<?php
/**
 * This class serves as the controller for the custom element Ssn.
 * Much of its functionality comes from the parent class 
 * Zend_Form_Element_Xhtml.
 * Since this is a composite element I overrode setValue and getValue methods.
 * The value comes in as an array. I convert it into a string because 
 * Zend validators deal with strings and not arrays.
 *
 * @author Rayhan Muktader <rmuktader@gmail.com>
 */
class RM_Form_Element_Ssn
    extends Zend_Form_Element_Xhtml 
{
    /**
     * @var string $helper.
     * The parent class will find the view helper to with this name and use it
     * to render the element.  In this case I created a custom view helper
     * ssnElement.  Custom view helpers must be added:
     * $view->setHelperPath('/path/to/more/helpers', 'My_View_Helper');
     * or 
     * autoloaderNamespaces[] = "My"
     * resources.view.helperPath.My_View_Helper = "My/View/Helper"
     * with the folder My in the library folder
     */
    public $helper       = 'ssnElement';
    
    /**
     * @var integer $_areanum
     * Holds the first three digits of a SSN.
     */
    protected $_areanum   = null;
    
    /**
     * @var integer $_groupnum
     * Holds the middle two digits of a SSN.
     */
    protected $_groupnum  = null;
    
    /**
     * @var integer $_serialnum
     * Holds the last four digits of a SSN.
     */
    protected $_serialnum = null;
    
    
    /**
     * @param array $value containing the $value['areanum'], 
     * $value['groupnum'] and $value['serialnum'] of a SSN.
     * 
     * @return void
     */
    public function setValue( $value )
    { 
        if ( is_array( $value )  
            && isset( $value['areanum'] ) 
            && isset( $value['groupnum'] ) 
            && isset( $value['serialnum'] ) 
        ) { 
            $this->setAreanum( $value['areanum'] )
                ->setGroupnum( $value['groupnum'] )
                ->setSerialnum( $value['serialnum'] );
        
        }
        
    }
    
    /**
     * @return string $value, the value set for this element if it is a 
     * valid value.
     */
    public function getValue()
    {
        $value = false;
       
        if ( $this->isValidAreanum($this->_areanum) && 
            $this->isValidGroupnum($this->_groupnum) && 
            $this->isValidSerialnum($this->_serialnum) ) {
            
            $value = $this->_areanum . $this->_groupnum .  $this->_serialnum;
        }
        
        return $value;
    }
    
    /**
     * @param string|int $num the first three digits of a SSN.
     * @return object $this.
     */
    public function setAreanum( $num )
    {
        $this->_areanum = $num;
        return $this;
    }
   
    /**
     * @param string|int $num the middle two digits of a SSN.
     * @return object $this.
     */   
    public function setGroupnum( $num )
    {
        $this->_groupnum = $num;
        return $this;
    }
    
    /**
     * @param string|int $num the last four digits of a SSN.
     * @return object $this.
     */    
    public function setSerialnum( $num )
    {
        $this->_serialnum = $num;
        return $this;
    }
    
    /**
     * @param string|int $num the first three digits of a SSN.
     * @return bool TRUE if valid FALSE otherwise.
     */
    public function isValidAreanum( $num )
    {
        $isValid = false;
        
        $intOptions = array("options"=>
            array("min_range"=>100, "max_range"=>999));

        if ( filter_var( $num, FILTER_VALIDATE_INT, $intOptions ) ) {
            $isValid = true; 
        }
        
        return $isValid;
    }
    
    /**
     * @param string|int $num the middle two digits of a SSN.
     * @return bool TRUE if valid FALSE otherwise.
     */
    public function isValidGroupnum( $num )
    {
        $isValid = false;
        
        $intOptions = array("options"=>
            array("min_range"=>10, "max_range"=>999));

        if ( filter_var( $num, FILTER_VALIDATE_INT, $intOptions ) ) {
            $isValid = true; 
        }
        
        return $isValid;
    }
    
    /**
     * @param string|int $num the last four digits of a SSN.
     * @return bool TRUE if valid FALSE otherwise.
     */
    public function isValidSerialnum( $num )
    {
        $isValid = false;
        
        $intOptions = array("options"=>
            array("min_range"=>1000, "max_range"=>9999));

        if ( filter_var( $num, FILTER_VALIDATE_INT, $intOptions ) ) {
            $isValid = true; 
        }
        
        return $isValid;
    }
}