 var pc = null,
     where = 0,
   initial = [2, 5, 10, 1],
      test = null,
    random = null,
    hiding = [],
    ivalid = null,
   spinner = null;
    
    Array.prototype.toString = function(){
        var res = "";
        for (var i = 0; i < this.length - 1; i++) {
            res += this[i] + ", ";
        }
        res += this[this.length - 1];
        return res;
    };
    
    window.onload = function(){
        pc = new PieChart();
        pc.setValues(initial);
        pc.printTo("pie");
        spinner = document.getElementById("spinner");
        test = document.getElementById("test");
        ivalid = document.getElementById("valid");
        var form = document.getElementById("pie-form");
        
	if (form && test) {
		//inserted these next 3 lines to make it update a lot
		eval("initial = [" + test.value + "]");
                pc.setValues(initial);
                test.value = initial;
            form.onsubmit = function(){
                if (test.valid) {
                    if (test.digits) {
                        eval("initial = [" + test.value + "]");
                        pc.setValues(initial);
                        test.value = initial;
                    } else {
                        Ajax.send("/flitags=" + escape(test.value), null, "post", onGetBack);
                        spinner.style.display = "block";
                    }
                }
                return false;
            };
        }

	// gets the info for these based off the button id's on the html
        var rotcc = document.getElementById("rot-cc");
        var rotacc = document.getElementById("rot-acc");
        var perc = document.getElementById("perc");
        if (rotcc && rotacc) {
            rotcc.onmousedown = function(){
                where = 1;
            };
            rotacc.onmousedown = function(){
                where = -1;
            };
            document.documentElement.onmouseup = function(){
                where = 0;
            };
            perc.onclick = function(){
                pc.title();
            };
        }
        var defvalues = document.location.search.replace(/\?/g, "");
        if (defvalues && test && form) {
            test.value = defvalues;
            spin();
            form.onsubmit();
        } else {
            spin();
        }
        //alert(defvalues);
    };
    
    
    function onGetBack () {
        pc.setValues(eval("[" + Ajax.getXML() + "]"), test.value);//TODO
        spinner.style.display = "none";
        pc.setTitle(2);
    }
    
    
    function spin () {
        if (where) {
            pc.rotate(where);
        }
        if (test && test.newvalue != test.value) {
            if (/^\d*\.?\d+(\s*,\s*\d*\.?\d+)*$/.test(test.value)) {
                test.className = "";
                test.valid = true;
                test.digits = true;
                ivalid.style.visibility = "hidden";
            } else {
                if (/^[\dA-Za-z]*\.?[\dA-Za-z]+(\s*,\s*[\dA-Za-z]*\.?[\dA-Za-z]+)*$/.test(test.value)) {
                    test.className = "flickr";
                    test.valid = true;
                    test.digits = false;
                    ivalid.src = "flickr.png";
                    ivalid.alt = "flickr";
                    ivalid.style.visibility = "visible";
                } else {
                    test.className = "error"
                    test.valid = false;
                    ivalid.src = "!.png";
                    ivalid.alt = "!";
                    ivalid.style.visibility = "visible";
                }
            }
            test.newvalue = test.value;
        }
        if (hiding.length) {
            for (var i = 0; i < hiding.length; i++) {
                hiding[i].obj.className = "opacity" + hiding[i].opacity--;
            }
            while (hiding[0].opacity == 0) {
                hiding.shift();
            }
        }
        setTimeout(spin, 1);
    }
    
    
    function randomizer () {
        for (var i = 0; i < initial.length; i++) {
            initial[i] += Math.round(Math.random() * 2) - 1;
            if (initial[i] < 0) {
                initial[i] = Math.abs(initial[i]);
            }
        }
        pc.setValues(initial);
        test.value = initial;
        random = setTimeout(randomizer, 100);
    }
    
