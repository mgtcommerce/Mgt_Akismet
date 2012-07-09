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
 * Mgt Akismet Observer
 *
 * @category   Mgt
 * @package    Mgt_Akismet
 * @author     Stefan Wieczorek <stefan.wieczorek@mgt-commerce.com>
 */

class Mgt_Akismet_Model_Observer
{
    public function checkReviewForSpam(Varien_Event_Observer $observer)
    {
        $review = $observer->getEvent()->getObject();
        $akismet = $this->_getAkismet();
        if ($akismet->isActive() && isset($review)) {
            $reviewData = array(
                'name' => $review->getNickname(),
                'comment' => $review->getTitle().' '.$review->getComment()
            );
            if ($akismet->isSpam($reviewData)) {
                throw new Exception('Akismet Spam Detected');
            }
        }
    }
    
    protected function _getAkismet()
    {
        return Mage::getSingleton('mgt_akismet/akismet');
    }
}