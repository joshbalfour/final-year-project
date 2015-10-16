create or replace view v_levelcrossing as 
	select id, 
		name,
		trim(substring_index(type,'  ',1)) accessibility,
		trim(substring_index(type,'  ',-1)) crossing_method,
		cast(lat as decimal(9,6)) lat, 
		cast(lng as decimal(9,6)) lng, 
		cast(replace(left(line_speed,3),'m','') as unsigned) speed,
		trains_per_day,
		train_types
	from levelcrossing;