<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link http://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\DeviceNetworkInformation\Reports;

use Piwik\Piwik;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\DeviceNetworkInformation\Columns\DeviceNetworkType;

class GetNetworkType extends Base
{
    protected function init()
    {
        parent::init();
        $this->dimension     = new DeviceNetworkType();
        $this->name          = Piwik::translate('DeviceNetworkInformation_DeviceNetworkType');
        $this->documentation = ''; // TODO
        $this->order = 11;
        $this->hasGoalMetrics = true;
        $this->subcategoryId = 'DevicesDetection_Devices';
    }

    public function configureView(ViewDataTable $view)
    {
        $view->config->show_search = true;
        $view->config->show_exclude_low_population = false;
        $view->config->addTranslation('label', Piwik::translate("DeviceNetworkInformation_dataTableLabelNetworkTypes"));
    }

}
