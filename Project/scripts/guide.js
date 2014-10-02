var Food = {
    index: window.localStorage.getItem("food:index"),
    $table: document.getElementById("food-table"),
    $form: document.getElementById("food-form"),
    $button_save: document.getElementById("food-op-save"),
    $button_discard: document.getElementById("food-op-discard"),

    init: function() {
        // initialize storage index
        if (!Food.index) {
            window.localStorage.setItem("Food:index", Food.index = 1);
        }

        // initialize form
        Food.$form.reset();
        Food.$button_discard.addEventListener("click", function(event) {
            Food.$form.reset();
            Food.$form.id_entry.value = 0;
        }, true);
        Food.$form.addEventListener("submit", function(event) {
            var entry = {
                id: parseInt(this.id_entry.value),
                name: this.name.value,
                rating: this.rating.value,
                comment: this.comment.value
            };
            if (entry.id == 0) { // add
                Food.storeAdd(entry);
                Food.tableAdd(entry);
            }
            else { // edit
                Food.storeEdit(entry);
                Food.tableEdit(entry);
            }

            this.reset();
            this.id_entry.value = 0;
            event.preventDefault();
        }, true);

        // initialize table
        if (window.localStorage.length - 1) {
            var food_list = [], i, key;
            for (i = 0; i < window.localStorage.length; i++) {
                key = window.localStorage.key(i);
                if (/Food:\d+/.test(key)) {
                    food_list.push(JSON.parse(window.localStorage.getItem(key)));
                }
            }

            if (food_list.length) {
                food_list
                    .sort(function(a, b) {
                        return a.id < b.id ? -1 : (a.id > b.id ? 1 : 0);
                    })
                    .forEach(Food.tableAdd);
            }
        }
        Food.$table.addEventListener("click", function(event) {
            var op = event.target.getAttribute("data-op");
            if (/edit|remove/.test(op)) {
                var entry = JSON.parse(window.localStorage.getItem("Food:"+ event.target.getAttribute("data-id")));
                if (op == "edit") {
                    Food.$form.name.value = entry.name;
                    Food.$form.rating.value = entry.rating;
                    Food.$form.comment.value = entry.comment;
                    Food.$form.id_entry.value = entry.id;
                }
                else if (op == "remove") {
                    if (confirm('Are you sure you want to remove "'+ entry.first_name +'" from your list?')) {
                        Food.storeRemove(entry);
                        Food.tableRemove(entry);
                    }
                }
                event.preventDefault();
            }
        }, true);
    },

    storeAdd: function(entry) {
        entry.id = Food.index;
        window.localStorage.setItem("Food:index", ++Food.index);
        window.localStorage.setItem("Food:"+ entry.id, JSON.stringify(entry));
    },
    storeEdit: function(entry) {
        window.localStorage.setItem("Food:"+ entry.id, JSON.stringify(entry));
    },
    storeRemove: function(entry) {
        window.localStorage.removeItem("Food:"+ entry.id);
    },

    tableAdd: function(entry) {
        var $tr = document.createElement("tr"), $td, key;
        for (key in entry) {
            if (entry.hasOwnProperty(key)) {
                $td = document.createElement("td");
                $td.appendChild(document.createTextNode(entry[key]));
                $tr.appendChild($td);
            }
        }
        $td = document.createElement("td");
        $td.innerHTML = '<a data-op="edit" data-id="'+ entry.id +'">Edit</a> | <a data-op="remove" data-id="'+ entry.id +'">Remove</a>';
        $tr.appendChild($td);
        $tr.setAttribute("id", "entry-"+ entry.id);
        Food.$table.appendChild($tr);
    },
    tableEdit: function(entry) {
        var $tr = document.getElementById("entry-"+ entry.id), $td, key;
        $tr.innerHTML = "";
        for (key in entry) {
            if (entry.hasOwnProperty(key)) {
                $td = document.createElement("td");
                $td.appendChild(document.createTextNode(entry[key]));
                $tr.appendChild($td);
            }
        }
        $td = document.createElement("td");
        $td.innerHTML = '<a data-op="edit" data-id="'+ entry.id +'">Edit</a> | <a data-op="remove" data-id="'+ entry.id +'">Remove</a>';
        $tr.appendChild($td);
    },
    tableRemove: function(entry) {
        Food.$table.removeChild(document.getElementById("entry-"+ entry.id));
    }
};
Food.init();