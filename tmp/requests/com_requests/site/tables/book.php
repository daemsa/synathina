<?php defined( '_JEXEC' ) or die( 'Restricted access' );

class TableBook extends JTable
{
  /**
  * Constructor
  *
  * @param object Database connector object
  */
  function __construct( &$db ) {
    parent::__construct('#__requests_books', 'book_id', $db);
  }
}
