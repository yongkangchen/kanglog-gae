function Calendar(){
	//var _this=this;
	var _cmd="getcalendar";

	//implements DataCacher
	this.Abstract(DataCacher,{
		getCmd:function(){
			return _cmd;
		}
	});

	this.show=function(year,month,today){
		if(month>12) {month=1;year++;}
		if(month<1) {month=12;year--;}
		_cmd="getcalendar&year="+year+"&month="+(month-1+1);
		this.getDatas([_creatCalendar,year,month,today]);
	}
	function _creatCalendar(calendar_data,year,month,today){
		var day = 1;
		var week=new Date(year,month-1,1).getDay();
		var daysOfMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
		daysOfMonth[1]=((0 == year % 4) && (0 != (year % 100))) || (0 == year % 400) ? 29 : 28;
		var days=daysOfMonth[month-1];
		var sumstr="";
		sumstr+="<table width=\"100%\" cellspacing=\"1\" id=\"calendar\">";
		sumstr+="	<tbody><tr><td class=\"calendar-top\" colspan=\"7\">";
		sumstr+="		<a href=\"javascript:blog.calendar.show("+(year-1)+","+month+");\"><</a>";
		sumstr+="		<span class=\"calendar-year\">"+year+"</span>";
		sumstr+="		<a href=\"javascript:blog.calendar.show("+(year-1+2)+","+month+","+today+");\">></a>";
		sumstr+="		<a href=\"javascript:blog.calendar.show("+year+","+(month-1)+","+today+");\"><</a>";
		sumstr+="		<a href=\"#calendar&"+year+"&"+month+"\"><span class=\"calendar-month\">"+(month-1+1)+"</span></a>";
		sumstr+="		<a href=\"javascript:blog.calendar.show("+year+","+(month-1+2)+","+today+");\">></a>";
		sumstr+="</td></tr>";
		sumstr+="<tr class=\"calendar-weekdays\">"
		sumstr+="	<td class=\"calendar-weekday-cell\">日</td>";
		sumstr+="	<td class=\"calendar-weekday-cell\">一</td>";
		sumstr+="	<td class=\"calendar-weekday-cell\">二</td>";
		sumstr+="	<td class=\"calendar-weekday-cell\">三</td>";
		sumstr+="	<td class=\"calendar-weekday-cell\">四</td>";
		sumstr+="	<td class=\"calendar-weekday-cell\">五</td>";
		sumstr+="	<td class=\"calendar-weekday-cell\">六</td>";
		sumstr+="</tr>";
		var j=0;
		while(day<=days){
			sumstr+="<tr class=\"calendar-weekdays\">";
			var k=0;
			var _day="";
			var _class="";
			var _id="";
			for(var i=0;i<=6;i++)
			{
				if(day>days) {j=0;_id="";_day="";break;}
				if(j>=week)
				{
					_day=day;
					_id="id=\"cal"+day+"\"";
					day++;
				}
				if(i==0)  _class="sun";
				else if(i==6) _class="satur";
				else if(day-1==today) _class="to";
				else _class="";
				if(_day!="" && calendar_data[_day-1]){   
						_day="<a href=\"#calendar&"+year+"&"+month+"&"+_day+"\">"+_day+"</a>"
				}
				sumstr+="	<td class=\"calendar-"+_class+"day\" "+_id+">"+_day+"</td>";
				j++;
			}
			sumstr+="</tr>";
		}
		sumstr+="</tbody></table>";
		$("Calendar-content").innerHTML=sumstr;
		
	}
}
