function PieChart () {
    var colors = ["#00a651", "#f66", "#00aeef", "#a67c52", "#ffcc00", "#662d91", "#8dc63f", "#92278f", "#f7941d", "#0054a6", "#ccc"],
         items = [],
        titles = [],
           sum = 0,
        labels = [],
         title = 0, //0 - digits, 1 - percent, 2 - titles
           div = null,
             S = 15;
       teacher = 1; //the roll of the viewer, 1 - Teacher
    this.start = 0; //deg
    this.sum = 0;
    this.setValues = function(){
        items = [];
        titles = [];
        labels = [];
        if (typeof this.setValues.arguments[0] == "object" && this.setValues.arguments[0].length) {
            items = this.setValues.arguments[0];
            if (typeof this.setValues.arguments[1] == "object" && this.setValues.arguments[1].length) {
                titles = this.setValues.arguments[1];
            }
            if (typeof this.setValues.arguments[1] == "string") {
                titles = eval('["' + this.setValues.arguments[1].replace(/,/g, '","') + '"]');
            }
        } else {
            for (var i = 0; i < this.setValues.arguments.length; i++) {
                items[i] = this.setValues.arguments[i]
            }
        }
        if (!titles.length && title > 1) {
            title = 0;
        }
        this.redraw();
    };
    
    
    this.printTo = function(divid){
        div = document.getElementById(divid);
        if (!div) {
            return false;
        }
        build(this.start);
    };
    
    
    this.redraw = function(){
        if (div) {
            var divs = div.getElementsByTagName("div");
            while (divs.length) {
                div.removeChild(divs[0]);
            }
            build(this.start);
        }
    };
    
    //rotation function
    this.rotate = function(angle) {
        angle = this.start + angle;
        angle = 0;//angle % 360;
        if (angle < 0) {
            angle = 360 + angle;
        }
        this.start = angle;
        //this.redraw();
    };
    
    
    this.setTitle = function(newtitle){
        if (newtitle > 2) {
            newtitle = 0;
        }
        title = newtitle;
        if (title > 1 && !titles.length) {
            title = 0;
        }
        var pc = sum / 100;
        for (var i = 0, j = items.length; i < j; i++) {
            switch (title) {
                case 0 : labels[i].nodeValue = items[i]; break;
                case 1 : labels[i].nodeValue = Math.round(items[i] / pc * 10) / 10 + "%"; break;
                case 2 : labels[i].nodeValue = titles[i]; break;
            }
        }
    };
    
    
    this.title = function(){
        this.setTitle(title + 1);
    };
    
    
    var build = function(start){
        if (!div) {
            return;
        }
        sum = 0;
        for (var i = 0; i < items.length; i++) {
            sum += items[i];
        }
        var pc = sum / 100;
        var alpha = 2 * Math.PI / sum,
                Q = 1,
                q = 1,
            angle = 0,
            whole = start * Math.PI / 180,
            sigma = 0.01,
                Z = 10;
        for (var i = 0; i < items.length; i++) {
            //labels
            var labeldiv = document.createElement("div");
            var labelspan = document.createElement("span");
            
	    switch (title) {
                case 0 : var labeltext = items[i]; break;
                case 1 : var labeltext = Math.round(items[i] / pc * 10) / 10 + "%"; break;
                case 2 : var labeltext = titles[i]; break;
            }
	    // if the roll is teacher make percentage visible, or score.
            if (teacher == 1){
     	        labels[i] = document.createTextNode(labeltext);
     	        labelspan.appendChild(labels[i]);
     	        labeldiv.appendChild(labelspan);
     	        labeldiv.className = "pie-label";
     	        var labelangle = (whole + alpha * items[i] / 2) % (Math.PI * 2);
     	        labeldiv.style.top = (labelangle > Math.PI?1:-1) * (S / 3 * 2 * Math.abs(Math.sin(labelangle))) + "em";
     	        labeldiv.style.left = (labelangle < Math.PI / 2 || labelangle > Math.PI / 2 * 3?1:-1) * (S / 3 * 2 * Math.abs(Math.cos(labelangle))) + "em";
     	        div.appendChild(labeldiv);

	         }
            if (items[i] == 0) {
                labeldiv.style.display = "none";
            }

            var sector = document.createElement("div");
            whole += alpha * items[i];
            angle = whole - Math.PI / 2 * (Q - 1);
            while (angle > Math.PI / 2 + sigma) {
                var bg = document.createElement("div");
                bg.className = "bg sector-" + q;
                bg.style.backgroundColor = colors[i % colors.length];
                bg.style.zIndex = Z--;
                div.appendChild(bg);
                Q++;
                Z = 10 * Q;
                if (Q > 4) {
                    q = Q - 4;
                } else {
                    q = Q;
                }
                angle = whole - Math.PI / 2 * (Q - 1);
            }
            if (Math.abs(Math.PI / 2 - angle) <= sigma) { //almost 90 deg
                var bg = document.createElement("div");
                bg.className = "bg sector-" + q;
                bg.style.backgroundColor = colors[i % colors.length];
                bg.style.zIndex = Z--;
                div.appendChild(bg);
                Q++;
                Z = 10 * Q;
                if (Q > 4) {
                    q = Q - 4;
                } else {
                    q = Q;
                }
            } else {
                sector.className = "pie sector-" + q;
                var size = Math.abs(S * Math.tan(angle));
                var size2 = S;
                if (size > 0) {
                    if (size > S) {
                        size2 = S * Math.cos(angle) / Math.sin(angle);
                        size = S;
                        sector.style[[0, "width", "height", "width", "height"][q]] = S - size2 + "em";
                    }
                    sector.style["border" + [0, "Left", "Bottom", "Right", "Top"][q]] = "solid " + size2 + "em transparent";
                    sector.style["border" + [0, "Bottom", "Right", "Top", "Left"][q]] = "solid " + size + "em " + colors[i % colors.length];
                    sector.size = size;
                    sector.colour = colors[i % colors.length];
                    sector.style.zIndex = Z--;
                    div.appendChild(sector);
                }
            }
        }
    };
}
