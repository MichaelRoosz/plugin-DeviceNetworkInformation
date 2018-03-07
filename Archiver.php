<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\DeviceNetworkInformation;

use Piwik\Common;
use Piwik\Metrics;

class Archiver extends \Piwik\Plugin\Archiver
{
    const NETWORK_TYPE_RECORD_NAME = 'DeviceNetworkInformation_networkTypes';
    const NETWORK_TYPE_FIELD = "config_device_networktype";

    public function aggregateDayReport()
    {
        $this->aggregateByLabel(self::NETWORK_TYPE_FIELD, self::NETWORK_TYPE_RECORD_NAME);
    }

    public function aggregateMultipleReports()
    {
        $dataTablesToSum = array(
            self::NETWORK_TYPE_RECORD_NAME,
        );

        $columnsAggregationOperation = null;

        foreach ($dataTablesToSum as $dt) {
            $this->getProcessor()->aggregateDataTableRecords(
                $dt,
                $this->maximumRows,
                $this->maximumRows,
                $columnToSort = 'nb_visits',
                $columnsAggregationOperation,
                $columnsToRenameAfterAggregation = null,
                $countRowsRecursive = array());
        }
    }

    private function aggregateByLabel($labelSQL, $recordName)
    {
        $metrics = $this->getLogAggregator()->getMetricsFromVisitByDimension($labelSQL);

        $labelSQL = str_replace('log_visit.', 'log_conversion.', $labelSQL);

        $query = $this->getLogAggregator()->queryConversionsByDimension(array($labelSQL));

        if ($query === false) {
            return;
        }

        while ($conversionRow = $query->fetch()) {
            $metrics->sumMetricsGoals(isset($conversionRow[$labelSQL]) ? $conversionRow[$labelSQL] : null, $conversionRow);
        }
        $metrics->enrichMetricsWithConversions();

        $table = $metrics->asDataTable();
        $report = $table->getSerialized($this->maximumRows, null, Metrics::INDEX_NB_VISITS);
        Common::destroy($table);
        $this->getProcessor()->insertBlobRecord($recordName, $report);
        unset($table, $report);
    }

}
