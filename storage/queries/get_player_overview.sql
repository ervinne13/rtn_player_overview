SELECT 
	player_id, 
    param_id,
    YEAR(match_date) as match_year,
    football_name,    
    match_stat_parameters.name as statistic,
    SUM(match_stats_bk.value)
FROM rtn_player_overview.match_stats_bk
LEFT JOIN matches ON match_id = matches.id
LEFT JOIN players ON player_id = players.id
LEFT JOIN match_stat_parameters ON param_id = match_stat_parameters.id
GROUP BY player_id, param_id, match_year
LIMIT 1000;