<?php
/**
 * This validation class makes sure that there's at least one 5 in the value.
 * Much of its functionality comes from the parent class 
 * Zend_Validate_Abstract.
 * This is just a silly example. It can be changed to check for more than one
 * error and used with different form elements.
 *
 * @author Rayhan Muktader <rmuktader@gmail.com>
 */
class RM_Validate_SpecialSsn
    extends Zend_Validate_Abstract
{
    const INVALID_SPECIAL_SSN = 'invalidSpecialSsn';
    
    /**
     * @var array $_messageTemplates holds all the names of the errors 
     * and the corresponding error messages
     */
    protected $_messageTemplates = array(
        self::INVALID_SPECIAL_SSN => "Sorry we are only accepting spcial 
        social security numbers that have at least one 5 in them. %value% 
        is not a special social security number"
    );
    
    
    /**
     * @param string $value the value of the form element
     * @return bool return true if it is a "special" SSN, false otherwise
     */
    public function isValid( $value )
    {
        $isValid = FALSE;
        
        // chech if  the value contains a 5
        if ( strpos( $value, '5' ) !== FALSE ) {
            $isValid = TRUE;
        } else {
        
            // sets the value in the form element and makes it available to
            // be printed out in the error message
            $this->_setValue( $value );
            
            $this->_error( self::INVALID_SPECIAL_SSN );
        }
        
        return $isValid;
    }
}