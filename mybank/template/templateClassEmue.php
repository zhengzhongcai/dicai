<?php
class TemplateEmue
{
	public function TemplateEmue()
	{}
	/*public function CreateEmue()
	{
		FTLR1 = 0,   //宽屏(4:3)
		FTLR2 = 1,   //宽屏(16:10)
		FTLR3 = 2,   //宽屏(1366/768)
		FTLR4 = 3,   //宽屏(16:9)
		FTLR5 = 4,   //竖屏(3:4)
		FTLR6 = 5,   //竖屏(10:16)
		FTLR7 = 6,   //竖屏(768/1366)
		FTLR8 = 7,   //竖屏(9:16)
	}*/
	public function getBaseInfo($tlr)
	{
		switch($tlr)
		{
			//宽屏
			case 0:return "1024x768";break;
			case 1:return "800x600";break;
			case 2:return "1280x1024";break;
			case 3:return "1600x1200";break;
			case 4:return "1280x800";break;
			case 5:return "1440x900";break;
			case 6:return "1680x1050";break;
			case 7:return "1920x1200";break;
			case 8:return "1366x768";break;
			case 25:return "1360x768";break;
			case 9:return "1920x1080";break;
			case 20:return "1024x600";break;
			case 21:return "1280x720";break;
            case 22:return "720x480";break;
            case 23:return "720x576";break;
			case 24:return "800x480";break;
			case 32:return "1600x900";break;
			//竖屏
			case 10: return "768x1024";  break;
			case 11: return "600x800";   break;
			case 12: return "1024x1280"; break;
			case 13: return "1200x1600"; break;
			case 14: return "800x1280";  break;
			case 15: return "900x1440";  break;
			case 16: return "1050x1680"; break;
			case 17: return "1200x1920"; break;  
			case 18: return "768x1366";  break;
			case 19: return "1080x1920"; break;
			case 26: return "480x720"; break;
			case 28: return "480x800"; break;
			case 27: return "576x720"; break;
			case 30: return "720x1280"; break;
			case 31: return "768x1360"; break;
			case 29: return "600x1024"; break;
			case 33:return "900x1600";break;	
		}
	}
}
?>