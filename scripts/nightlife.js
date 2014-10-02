var Bar = {
    index: window.localStorage.getItem("bar:index"),
    $table: document.getElementById("bar-table"),
    $form: document.getElementById("bar-form"),
    $button_save: document.getElementById("bar-op-save"),
    $button_discard: document.getElementById("bar-op-discard"),

    init: function() {
        // initialize storage index
        if (!Bar.index) {
            window.localStorage.setItem("Bar:index", Bar.index = 1);
        }

        // initialize form
        Bar.$form.reset();
        Bar.$button_discard.addEventListener("click", function(event) {
            Bar.$form.reset();
            Bar.$form.id_entry.value = 0;
        }, true);
        Bar.$form.addEventListener("submit", function(event) {
            var entry = {
                id: parseInt(this.id_entry.value),
                first_name: this.first_name.value,
                last_name: this.last_name.value,
                email: this.email.value
            };
            if (entry.id == 0) { // add
                Bar.storeAdd(entry);
                Bar.tableAdd(entry);
            }
            else { // edit
                Bar.storeEdit(entry);
                Bar.tableEdit(entry);
            }

            this.reset();
            this.id_entry.value = 0;
            event.preventDefault();
        }, true);

        // initialize table
        if (window.localStorage.length - 1) {
            var bar_list = [], i, key;
            for (i = 0; i < window.localStorage.length; i++) {
                key = window.localStorage.key(i);
                if (/Bar:\d+/.test(key)) {
                    bar_list.push(JSON.parse(window.localStorage.getItem(key)));
                }
            }

            if (bar_list.length) {
                bar_list
                    .sort(function(a, b) {
                        return a.id < b.id ? -1 : (a.id > b.id ? 1 : 0);
                    })
                    .forEach(Bar.tableAdd);
            }
        }
        Bar.$table.addEventListener("click", function(event) {
            var op = event.target.getAttribute("data-op");
            if (/edit|remove/.test(op)) {
                var entry = JSON.parse(window.localStorage.getItem("Bar:"+ event.target.getAttribute("data-id")));
                if (op == "edit") {
                    Bar.$form.first_name.value = entry.first_name;
                    Bar.$form.last_name.value = entry.last_name;
                    Bar.$form.email.value = entry.email;
                    Bar.$form.id_entry.value = entry.id;
                }
                else if (op == "remove") {
                    if (confirm('Are you sure you want to remove "'+ entry.first_name +'" from your list?')) {
                        Bar.storeRemove(entry);
                        Bar.tableRemove(entry);
                    }
                }
                event.preventDefault();
            }
        }, true);
    },

    storeAdd: function(entry) {
        entry.id = Bar.index;
        window.localStorage.setItem("Bar:index", ++Bar.index);
        window.localStorage.setItem("Bar:"+ entry.id, JSON.stringify(entry));
    },
    storeEdit: function(entry) {
        window.localStorage.setItem("Bar:"+ entry.id, JSON.stringify(entry));
    },
    storeRemove: function(entry) {
        window.localStorage.removeItem("Bar:"+ entry.id);
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
        Bar.$table.appendChild($tr);
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
        Bar.$table.removeChild(document.getElementById("entry-"+ entry.id));
    }
};
Bar.init();