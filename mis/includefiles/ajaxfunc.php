<script type="text/javascript">
/*function createXMLHttpRequest()
{
	var xmlHttp;
	if(window.ActiveXObject)
	{
		xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	else
	{
		xmlHttp=new XMLHttpRequest();
	}
	return xmlHttp;
}*/

/*function createXMLHttpRequest()
{
	var xmlhttp, bComplete = false;   
	try 
	{ 
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP"); 
	}   
	catch (e) 
	{ 
		try 
		{ 
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
		}   
		catch (e) 
		{ 
			try 
			{ 
				xmlhttp = new XMLHttpRequest(); 
			}   
			catch (e) 
			{ 
				xmlhttp = false; 
			}
		}
	}   
	if (!xmlhttp) 
		return null;   
	this.connect = function(sURL, sMethod, sVars, fnDone)   
	{     
		if (!xmlhttp) 
			return false;     
		bComplete = false;     
		sMethod = sMethod.toUpperCase();      
		try 
		{       
			if (sMethod == "GET")       
			{         
				xmlhttp.open(sMethod, sURL+"?"+sVars, true);         		sVars = "";       
			}       
			else
			{         
				xmlhttp.open(sMethod, sURL, true);         
				xmlhttp.setRequestHeader("Method", "POST "+sURL+" HTTP/1.1");    
				xmlhttp.setRequestHeader("Content-Type",           "application/x-www-form-urlencoded");       
			}       
			xmlhttp.onreadystatechange = function()
			{         
				if (xmlhttp.readyState == 4 && !bComplete)
				{           
					bComplete = true;           
					fnDone(xmlhttp);        
				}
			};       
			xmlhttp.send(sVars);     
		}     
		catch(z) 
		{ 
			return false; 
		}     
		return true;   
	};   
	return this;
}*/

function createXMLHttpRequest()
{
	var xmlhttp = false;   
	if(window.XMLHttpRequest) 
	{    
		xmlhttp = new XMLHttpRequest();   
	} 
	else if(window.ActiveXObject) 
	{    
		try 
		{     
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");    
		} 
		catch (e) 
		{     
			try 
			{      
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} 
			catch (e) 
			{      
				xmlhttp = false;     
			}    
		}   
	}   
	return xmlhttp;
}

function showTag(xmlOb,elemID)
{
	if(xmlOb.readyState==4&&xmlOb.status==200)
	{
		document.getElementById(elemID).innerHTML=xmlOb.responseText;
	}
}

function startpage()
{
	var stpage = createXMLHttpRequest();
	stpage.open("get","startpage.php",true);
	stpage.onreadystatechange= function ()
	{
		selectPage(stpage)
	}
	stpage.send(null);	
}

function selectPage(xmlOb)
{
	if(xmlOb.readyState==4&&xmlOb.status==200)
	{
		if(xmlOb.responseText=="loginpage")
		{
			loginpage();
		}
		else if(xmlOb.responseText=="adminpage")
		{
			adminpage();
		}
	}
}

function loginpage()
{
	var xmlLogin=createXMLHttpRequest();
	xmlLogin.open("get","loginpage.php",true);
	xmlLogin.onreadystatechange=function()
	{
		document.getElementById("mainmenuTD").innerHTML="";
		document.getElementById("menuTD").innerHTML="";
		showTag(xmlLogin,"mainTD");
	};
	xmlLogin.send(null);	
}

function startlogin()
{
	var user = document.getElementById("user").value;
	var pass = document.getElementById("pass").value;
	if(!user||!pass)
	{
			alert("ป้อน Username และ Password ");
			document.getElementById("user").value="";
			document.getElementById("pass").value="";
	}
	else
	{
		var xmlStLogin=createXMLHttpRequest();
		var url="login.php?username="+user+"&password="+pass;
		xmlStLogin.open("get",url,true);
		xmlStLogin.onreadystatechange=function ()
		{
			processlogin(xmlStLogin);
		}
		xmlStLogin.send(null);
	}	
}

function processlogin(xmlOb)
{
	if(xmlOb.readyState==4&&xmlOb.status==200)
	{
		if(xmlOb.responseText=="0")
		{
			alert("ป้อน Username หรือ Password ไม่ถูกต้อง");
			document.getElementById("user").value="";
			document.getElementById("pass").value="";
		}
		else
		{
			startpage();
		}
	}
}

function logout()
{
	var xmlLogout=createXMLHttpRequest();
	xmlLogout.open("get","logout.php",true);
	xmlLogout.onreadystatechange=function()
	{
		startpage();
	};
	xmlLogout.send(null);	
}

function adminpage()
{
	var xmlAdMmenu=createXMLHttpRequest();
	xmlAdMmenu.open("get","admin/mainmenu.php?tag=admin",true);
	xmlAdMmenu.onreadystatechange=function()
	{
		showTag(xmlAdMmenu,"mainmenuTD");
	};
	xmlAdMmenu.send(null);
	
	var xmlAdMenu=createXMLHttpRequest();
	xmlAdMenu.open("get","admin/menu.php?tag=admin",true);
	xmlAdMenu.onreadystatechange=function()
	{
		showTag(xmlAdMenu,"menuTD");
	};
	xmlAdMenu.send(null);
	
	var xmlAdMain=createXMLHttpRequest();
	xmlAdMain.open("get","admin/mainpage.php?tag=admin",true);
	xmlAdMain.onreadystatechange=function()
	{
		showTag(xmlAdMain,"mainTD");
	};
	xmlAdMain.send(null);	
}

function humanpage()
{
	var xmlHuMenu=createXMLHttpRequest();
	xmlHuMenu.open("get","admin/menu.php?tag=humanresource",true);
	xmlHuMenu.onreadystatechange=function()
	{
		showTag(xmlHuMenu,"menuTD");
	};
	xmlHuMenu.send(null);
	
	var xmlHuMain=createXMLHttpRequest();
	xmlHuMain.open("get","admin/mainpage.php?tag=humanresource",true);
	xmlHuMain.onreadystatechange=function()
	{
		showTag(xmlHuMain,"mainTD");
	};
	xmlHuMain.send(null);	
}

function hposition()
{
	var xmlHupMain=createXMLHttpRequest();
	xmlHupMain.open("get","admin/humanpos.php",true);
	xmlHupMain.onreadystatechange=function()
	{
		showTag(xmlHupMain,"mainTD");
	};
	xmlHupMain.send(null);

	var xmlHupShow=createXMLHttpRequest();
	xmlHupShow.open("get","admin/humanpos.php?tag=PosShow",true);
	xmlHupShow.onreadystatechange=function()
	{
		showTag(xmlHupShow,"subcontentTD");
	};
	xmlHupShow.send(null);
}

function AddHuPos()
{
	var xmlHupAdd=createXMLHttpRequest();
	xmlHupAdd.open("get","admin/humanpos.php?tag=PosInsertForm",true);
	xmlHupAdd.onreadystatechange=function()
	{
		showTag(xmlHupAdd,"subcontentTD");
	};
	xmlHupAdd.send(null);
}
</script>