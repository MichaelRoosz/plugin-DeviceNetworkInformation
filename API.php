<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\DeviceNetworkInformation;

use DeviceDetector\Parser\Device\DeviceParserAbstract;
use Piwik\Archive;
use Piwik\DataTable;
use Piwik\Metrics;
use Piwik\Piwik;

/**
 * The DevicesDetection API lets you access reports on your visitors devices, brands, models, Operating system, Browsers.
 * @method static \Piwik\Plugins\DevicesDetection\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    /**
     * @param string $name
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param string $segment
     * @return DataTable
     */
    protected function getDataTable($name, $idSite, $period, $date, $segment)
    {
        Piwik::checkUserHasViewAccess($idSite);
        $archive = Archive::build($idSite, $period, $date, $segment);
        $dataTable = $archive->getDataTable($name);
        $dataTable->queueFilter('ReplaceColumnNames');
        $dataTable->queueFilter('ReplaceSummaryRowLabel');
        return $dataTable;
    }

    /**
     * Gets datatable displaying number of visits by device network type
     * @param int $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable
     */
    public function getNetworkType($idSite, $period, $date, $segment = false)
    {
        $dataTable = $this->getDataTable('DeviceNetworkInformation_networkTypes', $idSite, $period, $date, $segment);
        //$dataTable->filter('GroupBy', array('label', __NAMESPACE__ . '\getDeviceNetworkTypeLabel'));
        $dataTable->filter('AddSegmentByLabel', array('deviceNetworkType'));
        return $dataTable;
    }
}
