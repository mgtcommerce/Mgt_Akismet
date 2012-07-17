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

class Mgt_Akismet_Model_Akismet extends Mage_Core_Model_Abstract
{
    const XML_PATH_MGT_AKISMET_ACTIVE = 'default/mgt_akismet/mgt_akismet/active';
    const XML_PATH_MGT_AKISMET_API_KEY = 'default/mgt_akismet/mgt_akismet/api_key';
    
    protected $_service;

    public function isSpam(array $data, $commentType = 'contact')
    {
        $isSpam = false;
        $service = $this->getService();
        $apiKey = $this->getApiKey();
        $helper = $this->getHelper();
        if ($service->verifyKey($apiKey)) {
            $data = new Varien_Object($data);
            $httpHelper = $this->getHttpHelper();
            $data = array(
                'user_ip'              => $httpHelper->getRemoteAddr(),
                'user_agent'           => $httpHelper->getHttpUserAgent(),
                'comment_type'         => $commentType,
                'comment_author'       => $data->getName(),
                'comment_author_email' => $data->getEmail(),
                'comment_content'      => $data->getComment()
            );
            if ($service->isSpam($data)) {
                $logMessage = sprintf('Akismet Spam Detected "%s" from IP: "%s"', $data['comment_content'], $data['user_ip']);
                $helper->log($logMessage);
                $isSpam = true;
            }
        } else {
            $logMessage = sprintf('Akismet ApiKey "%s" is not valid', $apiKey);
            $helper->log($logMessage);
        }
        return $isSpam;
    }
    
    public function isActive()
    {
        $isActive = (int)Mage::getConfig()->getNode(self::XML_PATH_MGT_AKISMET_ACTIVE);
        return $isActive;
    }
    
    public function getService()
    {
        if (!$this->_service) {
            $this->_service =  new Zend_Service_Akismet(self::getApiKey(), Mage::app()->getStore()->getBaseUrl());
        }
        return $this->_service;
    }
    
    public function getApiKey()
    {
        $apiKey = (string)Mage::getConfig()->getNode(self::XML_PATH_MGT_AKISMET_API_KEY);
        return trim($apiKey);
    }
    
    public function getHttpHelper()
    {
        return Mage::helper('core/http');
    }
    
    public function getHelper()
    {
    	return Mage::helper('mgt_akismet');
    }
}