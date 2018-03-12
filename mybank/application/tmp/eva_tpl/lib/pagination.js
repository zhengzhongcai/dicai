function PagerView(id){
	var self = this;
	this.id = id;

	this.container = null;

	this.index = 1; // 当前页码, 从1开始
	this.size = 15; // 每页显示记录数
	this.maxButtons = 5; // 显示的分页按钮数量
	this.itemCount = 0; // 记录总数
	this.pageCount = 0; // 总页数

	/**
	 * 控件使用者重写本方法, 获取翻页事件, 可用来向服务器端发起AJAX请求.
	 * @param index: 被点击的页码.
	 */
	this.onclick = function(index){
	};

	/**
	 * 内部方法.
	 */
	this._onclick = function(index){
		self.index = index;
		self.onclick(index);
		self.render();
	};

	/**
	 * 在显示之前计算各种页码变量的值.
	 */
	this.calculate = function(){
		self.pageCount = parseInt(Math.ceil(self.itemCount / self.size));
		self.index = parseInt(self.index);
		if(self.index > self.pageCount){
			self.index = self.pageCount;
		}
	};

	/**
	 * 渲染分页控件.
	 */
	this.render = function(){
		if(self.id != undefined){
			var div = document.getElementById(self.id);
			div.view = self;
			self.container = div;
		}

		self.calculate();

		var start, end;
		start = Math.max(1, self.index - parseInt(self.maxButtons/2));
		end = Math.min(self.pageCount, start + self.maxButtons - 1);
		start = Math.max(1, end - self.maxButtons + 1);

		var str = "";
		str += "<div class=\"pagenumarea\">\n";
		if(self.pageCount > 1){
			if(self.index != 1){
				str += '<a href="javascript://' + (self.index-1) + '"><div class="pageupbtn"></div></a>';
			}else{
				str += '<div class="pageupbtn_off"></div></a>';
			}
		}
		if(self.pageCount > 1){
			if(self.index != self.pageCount){
				str += '<a href="javascript://' + (self.index+1) + '"><div class="pagenextbtn"></div></a>';
			}else{
				str += '<div class="pagenextbtn_off"></div>';
			}
		}
		/*
		for(var i=start; i<=end; i++){
			if(i == this.index){
				str += '<span class="pagenum active">' + i + "</span>";
			}else{
				str += '<a href="javascript://' + i + '"><span class="pagenum">' + i + "</span></a>";
			}
		}
		
		str += ' 共' + self.pageCount + '页';
		*/
		str += "</div><!-- /.pagenumarea -->\n";
		
		self.container.innerHTML = str;

		var a_list = self.container.getElementsByTagName('a');
		for(var i=0; i<a_list.length; i++){
			a_list[i].onclick = function(){
				var index = this.getAttribute('href');
				if(index != undefined && index != ''){
					index = parseInt(index.replace('javascript://', ''));
					self._onclick(index)
				}
				return false;
			};
		}
	};
}