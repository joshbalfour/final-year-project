create or replace view v_train_times_with_crs as 
select from_crs, to_crs, from_time, to_time, rid 
from (
	select 
		t.from_crs,
		ifnull(if (
			t.to_crs='', 
			( 
				select t2.from_crs
				from x_train_times_with_crs t2
				where t.rid = t2.rid
				and t2.from_time >= t.to_time
				and from_crs!=''
				limit 1
			),
			t.to_crs
		),
		(
				select t2.to_crs
				from x_train_times_with_crs t2
				where t.rid = t2.rid
				and t2.from_time >= t.to_time
				limit 1
		)
		) to_crs,
		t.from_time,
		if ( 
			t.to_crs='', 
			( 
				select to_time
				from x_train_times_with_crs t3
				where t.rid = t3.rid
				and t3.from_time >= t.to_time
				and to_crs!=''
				limit 1
			), 
			t.to_time 
		) to_time,
		t.rid
	from x_train_times_with_crs t
) why_mysql_forces_you_to_make_table_aliases_well_never_know where from_crs != '' and to_crs != '';
