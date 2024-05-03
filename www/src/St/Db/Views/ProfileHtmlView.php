<?php

namespace St\Db\Views;

use St\Db\ProfileRow;
use St\Views\HtmlView;
use St\Views\IView;

class ProfileHtmlView extends HtmlView implements IView
{
    /**
     * Строки профиля выполнения запросов
     * @var ProfileRow[]
     */
    protected array $rows;

    /**
     * Устанавливает rows
     * @param array $rows
     * @return ProfileHtmlView
     * @see rows
     */
    public function setRows(array $rows): ProfileHtmlView
    {
        $this->rows = $rows;
        return $this;
    }

    #[\Override] public function out(): void
    {
        ?>

        <div style="width: 100%; padding: 10px">
            <h4>Times and resources</h4>
            <div>Request completed in: <strong><?php print sprintf("%0.5f sec", microtime(true) - ST_START_MICROTIME); ?></strong></div>
            <div>Memory usage: <strong><?php print sprintf("%0.2f mb", memory_get_usage() / 1024 / 1024); ?></strong></div>
            <div>Memory usage (real): <strong><?php print sprintf("%0.2f mb", memory_get_usage(true) / 1024 / 1024); ?></strong></div>
            <div>Memory usage (at peak): <strong><?php print sprintf("%0.2f mb", memory_get_peak_usage() / 1024 / 1024); ?></strong></div>
            <div style="margin-bottom: 10px">Memory usage (at peak and real): <strong><?php print sprintf("%0.2f mb", memory_get_peak_usage(true) / 1024 / 1024); ?></strong></div>

            <h4>SQL Profile</h4>
            <table style="width: 100%">
                <tr>
                    <th>Query ID</th>
                    <th>Duration (sec)</th>
                    <th>Query</th>
                </tr>

                <?php if (!$this->rows):?>
                    <tr>
                        <td style="text-align: center" colspan="3">No SQL Queries</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($this->rows as $row):?>
                    <tr>
                        <td><?php print $this->escape($row->getQueryID());?></td>
                        <td><?php print sprintf("%0.5f", $row->getDuration());?></td>
                        <td><?php print $this->escape($row->getQuery());?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>

        <?php
    }


}