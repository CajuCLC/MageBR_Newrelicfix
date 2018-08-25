<?php
/**
 * Class WMG_Adminhtml_Adminhtml_System_Email_TemplateController
 *
 * @category MageBR
 * @package  MageBR_Newrelicfix
 * @author   Eric Cavalcanti <magentobr@gmail.com>
 * @license  Apache License 2.0
 * @link     https://magebr.com/
 */
include_once("Mage/Adminhtml/controllers/System/Email/TemplateController.php");
class MageBR_Newrelicfix_Adminhtml_System_Email_TemplateController extends Mage_Adminhtml_System_Email_TemplateController
{
    /**
     *      * Set template data to retrieve it in template info form
     *           */
  public function defaultTemplateAction()
  {
    if (extension_loaded('newrelic')) {
        newrelic_disable_autorum();
    }
    $template = $this->_initTemplate('id');
    $templateCode = $this->getRequest()->getParam('code');

    $template->loadDefault($templateCode, $this->getRequest()->getParam('locale'));
    $template->setData('orig_template_code', $templateCode);
    $template->setData('template_variables', Zend_Json::encode($template->getVariablesOptionArray(true)));

    $templateBlock = $this->getLayout()->createBlock('adminhtml/system_email_template_edit');
    $template->setData('orig_template_used_default_for', $templateBlock->getUsedDefaultForPaths(false));

    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($template->getData()));
  }
}
?>
