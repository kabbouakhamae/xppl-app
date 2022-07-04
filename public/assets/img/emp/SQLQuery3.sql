



DECLARE @dateto DATETIME = '20220617'
DECLARE @pit VARCHAR(50) = 'pxn'
DECLARE @cont VARCHAR(50) = 'tg'


	DECLARE @tmp TABLE(
		c1 TINYINT
		,c2 NVARCHAR(5)
		,c3 NVARCHAR(300)
		,c4 NVARCHAR(300)
		,c5 NVARCHAR(300)
		,c6 NVARCHAR(300)
		,c7 NVARCHAR(300)
		,c8 NVARCHAR(10)
		,c9 NVARCHAR(10)
		,c10 NVARCHAR(10)
		,c11 NVARCHAR(10)
		,c12 NVARCHAR(10)
		)

	DECLARE @pit_lao NVARCHAR(200)
	DECLARE @cont_lao NVARCHAR(200)

	SET @pit_lao = (SELECT Lao FROM dbo.LKP_CODE WHERE Category ='pit' AND Code = @pit)
	SET @cont_lao = (SELECT Lao FROM dbo.LKP_CODE WHERE Category ='contractor' AND Code = @cont)


	/* pit */
	INSERT INTO @tmp (c1, c3)
	SELECT 0, @pit_lao +' ('+ @cont_lao +')'

	INSERT INTO @tmp (c1, c4, c11, c12)
	VALUES (1, N'1. ??????????????', N'???', N'????????')

   
	/* production report  */
	INSERT INTO @tmp (c1, c5, c6, c11, c12)
	SELECT
		a.id +1
		,'1.'+ CAST(a.id AS VARCHAR(2)) +'.' AS c5
		,a.descr AS c6
		,FORMAT(ISNULL(b.Ton, 0), '#,##0') AS c11
		,FORMAT(ISNULL(b.Grade, 0), '#,##0') AS c12
	FROM
		dbo.cutoff a
		LEFT OUTER JOIN 
		(	SELECT
				MinedCate
				,ROUND(SUM(CoalWeight_kg / 1000), 0) AS Ton
				,ROUND(SUM(CoalWeight_kg * GCV_ar) / SUM(CoalWeight_kg), 0) AS Grade
			FROM
				dbo.tbl_MinedProduction
			WHERE 
				MinedDate = @dateto
				AND Pit = @pit
				AND Cont = @cont
			GROUP BY 
				MinedCate
		) AS b ON a.ore_type = b.MinedCate


	/* total coal mined */
	DECLARE @ton FLOAT
	DECLARE @grade FLOAT

	SET @ton = (SELECT ROUND(SUM(CoalWeight_kg) / 1000, 0) FROM dbo.tbl_MinedProduction WHERE MinedDate = @dateto AND Pit = @pit AND Cont = @cont)
	SET @grade = (SELECT ROUND(SUM(CoalWeight_kg * GCV_ar) / SUM(CoalWeight_kg), 0) FROM dbo.tbl_MinedProduction WHERE MinedDate = @dateto AND Pit = @pit AND Cont = @cont)

	INSERT INTO @tmp (c1, c10, c11, c12)
	SELECT 7, N'???', FORMAT(@ton, '#,##0'), FORMAT(@grade, '#,##0')


	/* mined waste report */
	INSERT INTO @tmp (c1, c4)
	VALUES (8, N'2. ???????????')

	DECLARE @waste_trip FLOAT
	DECLARE @waste_vol FLOAT

	SET @waste_trip =(SELECT Qty FROM dbo.tbl_MinedWaste WHERE Items = 'waste trip' AND WorkDate = @dateto AND Pit = @pit AND Cont = @cont)
	SET @waste_vol =(SELECT Qty FROM dbo.tbl_MinedWaste WHERE Items = 'waste volume' AND WorkDate = @dateto AND Pit = @pit AND Cont = @cont)

	IF @ton IS NOT NULL
		BEGIN
			INSERT INTO @tmp (c1, c5, c6)
			SELECT
				9 AS c1
				,'2.1' AS c5
				,CASE WHEN @waste_trip IS NOT NULL THEN N'?????????????? '+ CAST(FORMAT(@waste_trip,'#,##0') AS VARCHAR(10)) + N' ????, ??????? '+ CAST(FORMAT(@waste_vol,'#,##0') AS VARCHAR(10)) + N' ???????? ??? ???????????????? '+ CAST(FORMAT(@waste_vol / @ton,'#,##0.00') AS VARCHAR(10)) + N' ????????/???' 
				 ELSE N'(???????????????????)' END AS c6			
		END
	ELSE
		BEGIN
		   	INSERT INTO @tmp (c1, c5, c6)
			SELECT 
				9 AS c1
				,'2.1.' AS c5
				,CASE WHEN @waste_trip IS NOT NULL THEN N'?????????????? '+ CAST(FORMAT(@waste_trip,'#,##0') AS VARCHAR(10)) + N' ????, ??????? '+ CAST(FORMAT(@waste_vol,'#,##0') AS VARCHAR(10)) + N' ????????, ?????????????????????????????????? 100%' ELSE
				N'(???????????????????)' END AS c6
		END


	/* blast hole report */
	INSERT INTO @tmp (c1, c4)
	VALUES (10, N'3. ????????????')
	
	INSERT INTO @tmp (c1, c5, c6)
	SELECT 
		11 AS c1
		,'3.1.' AS c5
		,CASE WHEN SUM(f.Hole) IS NOT NULL THEN N'??????????????? '+ CAST(FORMAT(SUM(f.Hole),'#,##0') AS VARCHAR(10)) + N' ??, ??? '+ CAST(FORMAT(SUM(f.m),'#,##0.0') AS VARCHAR(10)) + N' ????' ELSE
        N'(???????????????????????????????)' END AS c6
	FROM 
		(
			SELECT WorkDate, Pit, Cont, Qty AS Hole, 0 AS m FROM dbo.tbl_MinedWaste WHERE Items ='Blast drilled hole' UNION 
			SELECT WorkDate, Pit, Cont, 0 AS Hole, Qty AS m FROM dbo.tbl_MinedWaste WHERE Items ='Blast drilled meter'
		) AS f 
	WHERE 
		f.WorkDate =@dateto
		AND f.Pit =@pit
		AND f.Cont =@cont


	/* trenching report */

	IF @cont ='xppl'
		BEGIN
			INSERT INTO @tmp (c1, c4)
			VALUES (12, N'4. ????????????????????')

			INSERT INTO @tmp (c1, c5, c6)
			SELECT 
				12 AS c1
				,'4.1.' AS c5
				,CASE WHEN SUM(f.MxLen) IS NOT NULL THEN N'???????????? '+ CAST(FORMAT(COUNT(DISTINCT f.TRENCH_ID),'#,##0') AS VARCHAR(10)) + N' ???, ??? '+ CAST(FORMAT(SUM(f.MxLen),'#,##0.0') AS VARCHAR(10)) +N' ???? ??? ??????????????????????? '+ CAST(FORMAT(SUM(f.Samples),'#,##0') AS VARCHAR(10)) +N' ???????'
				ELSE N'(?????????????????)' END AS c5
			FROM 
				(	
					SELECT 
						a.PROSPECT
						,a.TRENCH_ID 
						,MAX(b.LEN_TO) AS MxLen
						,COUNT(c.SAMPLE_ID) AS  Samples 
					FROM 
						XPPL_EXPGEO_DB.dbo.GB_TR_SITE a, 
						XPPL_EXPGEO_DB.dbo.GB_TR_SITE_DETAIL b, 
						XPPL_EXPGEO_DB.dbo.GB_TR_SAMPLE_LITHOLOGY c
					WHERE 
						a.TRENCH_ID = b.TRENCH_ID
						AND a.TRENCH_ID = c.TRENCH_ID 
						AND c.SAMPLE_ID IS NOT NULL 
						AND b.WORK_DATE =@dateto 
						AND a.PROSPECT = CASE WHEN @pit ='K1W-C' THEN 'P2W' ELSE @pit END	
					GROUP BY 
						a.PROSPECT
						,a.TRENCH_ID
			) AS f 
		END

		
	/* add a blank row*/
	INSERT INTO @tmp (c1)
	VALUES (13)

	/* summary by contractor */
	INSERT INTO @tmp (c1, c3)
	SELECT 14, N'?????? '+ @cont_lao +N' ?????????????? ??? ?????????????? '+ @pit_lao +N' ?????????? '+ CONVERT(VARCHAR(10), @dateto, 103) 

	DECLARE @year_month VARCHAR(7)
	DECLARE @coal_plan FLOAT
	DECLARE @waste_plan FLOAT

	SET @year_month = CONVERT(VARCHAR(7), @dateto, 121)
	SET @coal_plan = (SELECT qty FROM dbo.tbl_MiningPlan WHERE category ='coal' AND pit = @pit AND cont = @cont AND monthly = @year_month)
	SET @waste_plan = (SELECT qty FROM dbo.tbl_MiningPlan WHERE category ='waste' AND pit = @pit AND cont = @cont AND monthly = @year_month)

	/* coal production */
	INSERT INTO @tmp (c1, c4)
	SELECT 15,
		N'? '+ CASE WHEN @ton IS NOT NULL THEN N'??????????????????????? '+ CAST(FORMAT(@coal_plan, '#,##0') AS VARCHAR(10)) +
		N' ???, ???????????? '+ CAST(FORMAT(@ton,'#,##0') AS VARCHAR(10)) +
		N' ???, ???????????? '+ CAST(FORMAT(@grade,'#,##0') AS VARCHAR(10)) +
		N' ?????????/????????. ??????? '+ CAST(FORMAT((@ton * 100)/@coal_plan,'#,##0') AS VARCHAR(10)) +'%'+
		CASE WHEN ((@ton - @coal_plan) / @coal_plan) * 100 >0 THEN N' ?????????? ' ELSE N' ?????????? ' END + CAST(FORMAT(((@ton - @coal_plan) / @coal_plan) * 100,'#,##0') AS VARCHAR(10)) +'%'
		ELSE N'??????????????????????? '+ CAST(FORMAT(@coal_plan,'#,##0') AS VARCHAR(10)) + N' ???: (??????????????????????)' END 

	/* high grade coal */
	INSERT INTO @tmp (c1, c4)
	SELECT 16,
		 N'? '+ CASE WHEN SUM(CoalWeight_kg) IS NOT NULL THEN N'????????????????????????? '+ CAST(FORMAT(SUM(CoalWeight_kg)/1000,'#,##0') AS VARCHAR(10)) +
		 N' ???, ???????????? '+ CAST(FORMAT(SUM(CoalWeight_kg * GCV_ar) / SUM(CoalWeight_kg), '#,##0') AS VARCHAR(10)) +
		 N' ?????????/????????. ??????? '+ CAST(FORMAT(((SUM(CoalWeight_kg) / 1000) *100) / @ton, '#,##0') AS VARCHAR(10)) +'%' ELSE N'(???????????????????????)' END AS c5
	FROM
	 	dbo.tbl_MinedProduction
	WHERE 
		MinedCate IN('SHG','HG')
		AND MinedDate = @dateto
		AND Pit = @pit
		AND Cont = @cont









	SELECT * FROM @tmp




















