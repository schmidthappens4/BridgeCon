<?php

/******************************************************************************
* Author:	Ray Schmidt
* Date:		February 18, 2017
* File:		phpForm.php
* Purpose:	Contains functions used to create and process PHP forms and
*				form information - updated to latest HTML 5 standards
******************************************************************************/
  
class phpForm
{
  //Attribute Section 
  protected $sBody;  // This declares an attribute for our class.
  
  //Method Sections
  
  /****************************************************************************
  * Constructor	- Initially set up the form
  * Params		- sName form Name
  *				- sAction where we are submitting
  *				- sMethod How We are submitting
  *				- sFormAttrs - Any additional Form Attributes
  ****************************************************************************/
  function phpForm ( $sName, $sAction, $sMethod="GET", $sAttrs ="" )
  {
    $this->sBody = "<form name='$sName' action='$sAction' " .
        "method='$sMethod' $sAttrs> \n";
  }

  /****************************************************************************
  * Function:	dumpForm
  * Purpose: 	This routine will proceed to dump our form information
  *					that we have gathered to this point
  * Params:  	$sSubKey - What goes with the submit button
  *				$sResetKey - What goes with the reset phrase
  *				$bShowButtons - Whether or not we want to see the buttons
  ****************************************************************************/  
  function dumpForm ( $sSubKey="submit", $sResetKey="reset",
            $bShowButtons=true )
  {
    if ( $bShowButtons )
    {
      $this->sBody .= "<div id=\"btnCenter\"<input type=submit " .
          "value='$sSubKey'><input type=reset value='$sResetKey'></div>\n";
    }
    $this->sBody .= "</form>\n";
    return $this->sBody;   
  }   
    
  /****************************************************************************
  * Function:	addText
  * Purpose: 	adds a string to the output
  * Params:  	sText - text to display
  *           	sName - id name of the text to be used with CSS
  ****************************************************************************/
  function addText ( $sText, $sName )
  {
    $this->sBody .= "<div id=\"$sName\" name=\"$sName\">$sText</div>\n";
  }

 /*****************************************************************************
  * Function:	addTextBox
  * Purpose: 	adds a text box to our form
  * Params:  	sLabel - a Label to associate with the text box
  *           	sName - the name of the text box
  *           	sParams - additional params (like size)
  ****************************************************************************/
  function addTextBox ( $sLabel, $sName, $sParams = "" )
  {
    $this->sBody .= "$sLabel<input type=\"text\" name=\"$sName\" " .
        " id=\"$sName\" $sParams > \n";
  }
  
  /****************************************************************************
  * Function:	addTextList
  * Purpose: 	takes a list of text box labels and names and adds the corresponding entries
  *					to our form body
  * Params: 	aTxtList - Associative array of Text box Labels and corresponding names
  *           	sParams  - Additional options string for each of the text boxes
  ****************************************************************************/
  function addTextList ( $aTxtList, $sParams="" )
  {
    foreach ( $aTxtList as $sLabel=>$sName )
    {
      $sVals = explode ( ":", $sName );
      
      if ( count ( $sVals ) == 2 )
      {
        $this->addText ( $sLabel, $sVals[0], $sVals[1] );
      }
      else
      {
        $this->addText ( $sLabel, $sVals[0], $sParams );
      }   
    }
  }

  /****************************************************************************
  * Function:	addRadio
  * Purpose: 	adds a radio button to the form in the next "slot"
  * Params:  	sLabel - Label to be assocaited with the radio button
  *           	sName - Name of the radio group that we are working with
  *				sID - ID attribute of the radio button
  *           	sValue - Value to be associated with the radio button
  ****************************************************************************/
  function addRadio ( $sLabel, $sName, $sID, $sValue )
  {
    $this->sBody .= "<label for=\"$sID\">$sLabel<input type=\"radio\"" .
        " value=\"$sValue\" name=\"$sName\" " .
        " id=\"$sID\">\n ";   
  }
   
  /****************************************************************************
  * Function:	addRadioGroup
  * Purpose: 	creates a list of associated radio buttons and adds them to the form
  * Params:  	sName - Name of the radio group to be created
  *           	aKeyVals - Associated list of Labels and values for the radio
  *             	group that is to be placed on the form
  *           	sHeader - A header that we are going to put out for our form
  ****************************************************************************/
  function addRadioGroup ( $sName, $aKeyVals, $sHeader )
  {
    $this->addLegend ( $sHeader );
    
    foreach ( $aKeyVals as $sLabel=>$sValue )
    {
      $this->addRadio ( $sLabel, $sName, $sValue );
    }
  }
   
  /****************************************************************************
  * Function:	addLegend
  * Purpose: 	outputs an appropriate header onto the current form
  * Params:  	sLegend - legend to be output
  ****************************************************************************/
  function addLegend ( $sLegend )
  {
    $this->sBody .= "<h2>$sLegend</h2>\n";
  }
   
  /****************************************************************************
  * Function:	addSelect
  * Purpose: 	adds a single select box to our form utilizing the appropriate format
  *					(line or table row)
  * Params:  	sLabel - the Label that is to be associated with our Select box
  *           	sName - the name of the select box
  *           	aKeyVals - assoicative array holding the different options
  *					for our working Select Box
  *           	sAttrs - additional Select box parameters
  ****************************************************************************/
  function addSelect ( $sLabel, $sName, $aKeyVals, $sAttrs= "" )
  {
    $this->startSelect ( $sLabel, $sName, $sAttrs );
       
    foreach ( $aKeyVals as $sKey => $sValue )
    {
      $this->addOption ( $sValue, $sKey );
    }
       
    $this->endSelect ();
  }

  /****************************************************************************
  * Function:	addOption
  * Purpose: 	adds an option item to our form
  * Params:  	sValue - value to be associated with this option
  *           	sKey - the key to be associated with the value
  ****************************************************************************/
  function addOption ( $sValue, $sKey )
  {
    $this->sBody .= "<option value=\"$sKey\">$sValue</option>\n ";
  }
   
  /****************************************************************************
  * Helper routines for Select Box (Drop-down list)
  *     - startSelect
  *     - end Select
  * Purpose: These routines just provide the bookend tags for our select boxes.
  ****************************************************************************/
  function startSelect ( $sLabel, $sName, $sAttr )
  {
    $this->sBody .= "$sLabel<select name=\"$sName\"" .
          " id=\"$sName\" $sAttr>\n";   
  }
    
  function endSelect ()
  {
    $this->sBody .= "</select>\n";
  }

} // End Class phpForm

/***************** phpTabForm  ************************************************
*    Class to output forms in nice tabular format
******************************************************************************/

class phpTabForm extends phpForm
{
  /****************************************************************************
   * Constructor:	Initially set up the form and the tabular output.
   * Params:  		sName - Form Name
   *             	sAction - Where we are submitting
   *             	sMethod - How We are submitting
   *             	sFormAttrs - Any additional Form Attributes
   *             	sTabAttrs - Any Additional Table Attributes
   ***************************************************************************/
  function phpTabForm ( $sName, $sAction, $sMethod="GET", $sFormAttrs="",
      $sTabAttrs="" )
  {
    //Call The parent Constructor
    $this->phpForm ( $sName, $sAction, $sMethod, $sFormAttrs );
    $this->sBody .= "<table $sTabAttrs>\n";
  }
 
  /****************************************************************************
  * Function: dumpForm
  * Purpose:  This routine will proceed to dump our form information
  *             that we have gathered to this point. We have a slight
  *             problem with this routine in that it is called 
  *             similarily to the parents dump form Routine.  To
  *             call the parent's dump form routine, we have to 
  *             preface the call with parent:: rather than $this->
  *             Just the way it's done.
  * Params:   $sSubmitPhrase - What goes with the submit button
  *           $sResetPhrase - What goes with the reset phrase
  *           $bShowButtons - Whether or not we want to see the buttons.
  ****************************************************************************/
  function dumpForm ( $sSubmitPhrase="Submit", $sResetPhrase="Reset",
      $bShowButtons=true )
  {
    if ( $bShowButtons )
    {
      $this->sBody .= "<tr><td class='txtRight'>" .
          "<input type='submit' value='$sSubmitPhrase'></td>" .
          "<td><input type='reset' value='$sResetPhrase'></td></tr>\n";
    }
    $this->sBody .= "</table></form>\n";
    return $this->sBody;
  }
      
  /****************************************************************************
  * Function: addText
  * Purpose:  To add some text to a table data cell.
  * Params:   sText - text to display
  *           sName - id name of the text to be used with CSS
  *           sColspan - used if you need to span multiple columns
  ****************************************************************************/
  function addText ( $sText, $sName, $sColspan=1 )
  {
    $this->sBody .= "<td id=\"$sName\" name=\"$sName\"" .
        " colspan=$sColspan>$sText</td>\n";
  }
 
  /****************************************************************************
  * Function: addTextBox
  * Purpose:  This routine shall write a text box and corresponding
  *             label out to our body string.
  * Params:   $sLabel - label to associate with the text
  *           $sName  - name of the text box
  *           $sAttrs  - additional attributes for text box
  ****************************************************************************/
  function addTextBox ( $sLabel, $sName="", $attrs="" )
  {
    $this->sBody .= "<tr><td class=\"txtLeft\">$sLabel" .
        "</td><td><input type=\"text\" name=\"$sName\"" .
        " id=\"$sLabel\" $attrs></td></tr>\n";
  }
     
  /****************************************************************************
  * Function: addPass
  * Purpose:  This routine will add a password field to the form
  * Params:   $sLabel - label to associate with the text
  *           $sName  - name of the text box
  *           $sAttrs  - additional attributes for text box
  ****************************************************************************/
  function addPass ( $sLabel, $sName="", $attrs="" )
  {
    $this->sBody .= "<tr><td class=\"txtLeft\">$sLabel" .
        "</td><td><input type=\"password\" name=\"$sName\"" .
        " id=\"$sLabel\" $attrs></td></tr>\n";
  }

  /****************************************************************************
  * Function: addHiddenTextBox
  * Purpose:  This routine will add a hidden text box to the body string.
  * Params:   $sLabel - label to associate with the text
  *           $sName  - name of the text box
  ****************************************************************************/
  function addHiddenTextBox ( $sLabel, $sValue )
  {
    $this->sBody .= "<tr><td><input type=\"hidden\" name=\"$sLabel\"" .
        " id=\"$sLabel\" value=\"$sValue\"></td></tr>\n";
  }

  /****************************************************************************
  * Function: addRadio
  * Purpose:  Just add a radio button to the form in the next "slot" in the
  *             table
  * Params:   sLabel - Label to be assocaited with the radio button
  *           sName - Name of the radio group that we are working with.
  *           sValue  - Value to be associated with the radio button.
  ****************************************************************************/
  function addRadio ( $sLabel, $sName, $sValue )
  {
    $this->sBody .= "<tr><td class=\"txtRight\">$sLabel</td>" .
        "<td><input type=\"radio\" value=\"$sValue\" name=\"$sName\"" .
        "id=\"$sName\"></td><tr>\n";
  }
   
  /****************************************************************************
  * Function: addLegend
  * Purpose:  This routine will be responsible for outputing
  *             an appropiate header onto the current form we are 
  *             working with.
  * Params:   sLegend - Legend to be output.
  ****************************************************************************/
  function addLegend ( $sLegend )
  {
    $this->sBody .= "<tr><td class=\"legend\" colspan=2>" .
              " $sLegend</td></tr>\n";
  }
    
  /****************************************************************************
  * Function: addTableRow
  * Purpose:  This routine will be responsible for adding a
  *             new table header row.
  * Params:   aHeaders - array of column Headings
  *           nCols - number of columns
  *           trAttrs - special attributes
  ****************************************************************************/
  function addTableRow ( $aHeaders, $nCols, $trAttrs )
  {
  $this->sBody .= "<tr $trAttrs>";
  for ( $i=0; $i < $nCols; $i++ )
  {
    $this->sBody .= "<td>$aHeaders[$i]</td>";
  }
  $this->sBody .= "</tr>";
  }

  /****************************************************************************
  * Function: addSelect
  * Purpose:  We are going to add a single select box to our
  *             form utilizing the appropriate format (line or table row).
  * Params:   sLabel - the Label that is to be associated with our Select box
  *           sName - the name of the select box.
  *           aKeyVals - associative array holding the different
  *             options for our working Select Box.
  *           sAttrs - additional Select box parameters.
  ****************************************************************************/
  function addSelect ( $sLabel, $sName, $aKeyVals, $sAttrs= "" )
  {
    $this->startSelect ( $sLabel, $sName, $sAttrs );
       
    foreach ( $aKeyVals as $sKey => $sValue )
    {
      $this->addOption ( $sValue, $sKey );
    }
       
    $this->endSelect ();
  }

  /****************************************************************************
  * Helper routines for Select Box
  *     - startSelect
  *     - end Select
  * Purpose:  These routines just provide the bookend tags for our
  *             select boxes.
  ****************************************************************************/
  function startSelect ( $sLabel, $sName, $sAttr="" )
  {
    $this->sBody .= "<tr><td class=\"txtRight\">$sLabel</td>\n" .
        "<td><select name=\"$sName\" id=\"$sName\"  $sAttr>\n";
  }
  
  function endSelect ()
  {
    $this->sBody .= "</select></td></tr>\n";
  }

  /****************************************************************************
  * Method:   addCheckBox
  * Purpose:  to add a check box to the form
  * Params:   sLabel - the label of the check box
  *           sValue - the value of the control
  *           initState - checked or not (default is checked)
  ****************************************************************************/
  function addCheckBox ( $sLabel, $sValue, $initState="" )
  {
    $this->sBody .= "<tr><td class=\"txtLeft\">$sLabel</td>\n" .
        "<td><input type=\"checkbox\" value=\"$sValue\" " .
        "name=\"$sLabel\" id=\"$sLabel\" $initState>" .
        "</td></tr>\n";
  }

  /****************************************************************************
  * Method:   addCheckList
  * Purpose:  to add a list of checkboxes using the values from an array
  * Params:   aList - array to be used
  ****************************************************************************/
  function addCheckList ( $aList )
  {
    $this->sBody .= "<td valign='top'>\n";
    foreach ( $aList as $name=>$value )
    {
      $this->sBody .= "<tr><td>";
      $this->sBody .= "<input type='checkbox' name='$name'" .
          " id='$name'>$value</input>";
      $this->sBody .= "</td></tr>\n";
    }
    $this->sBody .= "</td>";
  }

  /****************************************************************************
  * Method:   addElement
  * Purpose:  to add an element such as a specialized tag to a form
  * Params:   element - the element to be added to the form
  ****************************************************************************/
  function addElement ( $element )
  {
    $this->sBody .= $element;
  }

  /****************************************************************************
  * Method:   addLink
  * Purpose:  to add a link to the form
  * Params:   sLabel - describes the link
              sLink - the location to link to
  ****************************************************************************/
  function addLink ( $sLabel, $sLink )
  {
      $this->sBody .= "<tr><th colspan='2'><a href='$sLink'>" .
      "$sLabel</a></th></tr>\n";
  }
  
  /****************************************************************************
  * Method:   addImage
  * Purpose:  to add an image to the form
  * Params:   sSource - location of the image
  *           nHeight - height the image should be (default 200)
  *           nWidth - widht the image should be (default 300 )
  ****************************************************************************/
  function addImage ( $sSource, $nHeight=200, $nWidth=300 )
  {
      $this->sBody .= "<tr><th colspan='2'><img src=$sSource " .
      "height=$nHeight width=$nWidth /></th></tr>";
  }
} // End Class phpTabForm

?>
