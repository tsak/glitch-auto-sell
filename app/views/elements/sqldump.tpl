{if class_exists('ConnectionManager') && Configure::read('debug') >= 2}
  {$noLogs = !isset($logs)}
  {if $noLogs}
    {$sources = ConnectionManager::sourceList()}
    
    {$logs = array()}
    
    {foreach $sources as $source}
      {$db = ConnectionManager::getDataSource($source)}
		  {if $db->isInterfaceSupported('getLog')}
			 {$logs[$source] = $db->getLog()}
		  {/if}
    {/foreach}
  {/if}
{/if}

{if isset($noLogs) || isset($_forced_from_dbo_)}
  <style type="text/css">
    #cake-sql-log-container {
      margin-top: 5em;
    }
    
    #cake-sql-log-container caption {
      text-align: center;
    }
    
    .cake-sql-log {
    	background: #f4f4f4;
    	border: 1px solid;
    	border-collapse: collapse;
    }
    .cake-sql-log caption {
    	color:red;
    }
    .cake-sql-log td, .cake-sql-log th {
    	padding: 4px 8px;
    	text-align: left;
    	font-family: Monaco, Consolas, "Courier New", monospaced;
    	border: 1px solid;
    }
    .cake-sql-log caption {
    	color:#fff;
    }
  </style>
  <div id="cake-sql-log-container">
  {foreach $logs as $source => $logInfo}  
		<caption><strong>{$source}:</strong> {$logInfo.count} {if $logInfo.count > 1}queries{else}query{/if} took {$logInfo.time}ms</caption>
		<table class="cake-sql-log" id="cakeSqlLog_{$smarty.now|regex_replace:'/[^A-Za-z0-9_]/':'_'}" summary="Cake SQL Log">
  	<thead>
  		<tr><th>Nr</th><th>Query</th><th>Error</th><th>Affected</th><th>Num. rows</th><th>Took (ms)</th></tr>
  	</thead>
  	<tbody>
  	{foreach $logInfo.log as $k => $i}
    <tr>
      <td>{$k+1}</td>
      <td>{h($i['query'])}</td>
      <td>{$i['error']}</td>
      <td style="text-align: right;">{$i['affected']}</td>
      <td style="text-align: right;">{$i['numRows']}</td>
      <td style="text-align: right;">{$i['took']}</td>
    </tr>
  	{/foreach}
  	</tbody></table>
  {/foreach}
  </div>
{else}
  <p>Encountered unexpected $logs cannot generate SQL log</p>
{/if}