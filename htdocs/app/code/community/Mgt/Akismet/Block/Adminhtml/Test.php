<?php
/**
 * MGT-Commerce GmbH
 * http://www.mgt-commerce.com
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@mgt-commerce.com so we can send you a copy immediately.
 *
 * @category    Mgt
 * @package     Mgt_Akismet
 * @author      Stefan Wieczorek <stefan.wieczorek@mgt-commerce.com>
 * @copyright   Copyright (c) 2012 (http://www.mgt-commerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Mgt Akismet Test Block
 *
 * @category   Mgt
 * @package    Mgt_Akismet
 * @author     Stefan Wieczorek <stefan.wieczorek@mgt-commerce.com>
 */
 
class Mgt_Akismet_Block_Adminhtml_Test extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element) 
    {
        $this->setElement($element);
        return $this->_getWidgetButtonHtml($this->__('Test Api Key'));
    }
    
    protected function _getWidgetButtonHtml($title) 
    {
        $url = Mage::helper('adminhtml')->getUrl('mgtakismet/test/test', array());
        $widgetButton = $this->getLayout()->createBlock('adminhtml/widget_button');
        $widgetButton->setType('button')
            ->setLabel($this->__($title))
            ->setOnClick(sprintf("window.location.href='%s'", $url));
        return $widgetButton->toHtml();
    }
}