<?php
class FME_Percentagepricing_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	Mage::log("Entered indexAction for FME_Percentagepricing", null, "mylogfile.log");
    	/*
    	 * Load an object by id
    	 * Request looking like:
    	 * http://site.com/percentagepricing?id=15
    	 *  or
    	 * http://site.com/percentagepricing/id/15
    	 */

		$percentagepricing_id = $this->getRequest()->getParam('id');

		Mage::log("ID = " . $percentagepricing_id, null, "mylogfile.log");

  		if($percentagepricing_id != null && $percentagepricing_id != '')	{
			Mage::log("entering if", null, "mylogfile.log");
			$percentagepricing = Mage::getModel('percentagepricing/percentagepricing')->load($percentagepricing_id)->getData();
			Mage::log($percentagepricing, null, "mylogfile.log");

		} else {
			$percentagepricing = null;
		}


		
		 /*
    	 * If no param we load a the last created item
    	 */ 

    	if($percentagepricing == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$percentagepricingTable = $resource->getTableName('percentagepricing');
			
			$select = $read->select()
			   ->from($percentagepricingTable,array('percentagepricing_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$percentagepricing = $read->fetchRow($select);
		}
		Mage::register('percentagepricing', $percentagepricing);


			
		$this->loadLayout();
		$this->renderLayout();
    }
}