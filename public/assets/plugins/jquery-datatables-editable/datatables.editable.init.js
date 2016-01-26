/**
 * Theme: Montran Admin Template
 * Author: Coderthemes
 * Component: Editable
 * 
 */

(function ($) {

    'use strict';

    var EditableTable = {
        options: {
            addButton: '#addToTable',
            table: '.nameit',
            dialog: {
                wrapper: '#dialog',
                cancelButton: '#dialogCancel',
                confirmButton: '#dialogConfirm',
            }
        },
        initialize: function () {
            this
                    .setVars()
                    .build()
                    .events();
        },
        setVars: function () {
            this.$table = $(this.options.table);
            this.$addButton = $(this.options.addButton);

            // dialog
            this.dialog = {};
            this.dialog.$wrapper = $(this.options.dialog.wrapper);
            this.dialog.$cancel = $(this.options.dialog.cancelButton);
            this.dialog.$confirm = $(this.options.dialog.confirmButton);

            return this;
        },
        build: function () {
            this.datatable = this.$table.DataTable({
                aoColumns: [
                    {"bSortable": false},
                    {"bSortable": false},
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"bSortable": false}
                ]
            });

            window.dt = this.datatable;

            return this;
        },
        events: function () {
            var _self = this;

            this.$table
                    .on('click', 'a.save-row', function (e) {
                        e.preventDefault();
                        _self.rowSave($(this).closest('tr'));
                    })
                    .on('click', 'a.cancel-row', function (e) {
                        e.preventDefault();

                        _self.rowCancel($(this).closest('tr'));
                    })
                    .on('click', 'a.edit-row', function (e) {
                        e.preventDefault();

                        _self.rowEdit($(this).closest('tr'));
                    })
                    .on('click', 'a.remove-row', function (e) {
                        e.preventDefault();

                        var $row = $(this).closest('tr');

                        $.magnificPopup.open({
                            items: {
                                src: _self.options.dialog.wrapper,
                                type: 'inline'
                            },
                            preloader: false,
                            modal: true,
                            callbacks: {
                                change: function () {
                                    _self.dialog.$confirm.on('click', function (e) {
                                        e.preventDefault();

                                        _self.rowRemove($row);
                                        $.magnificPopup.close();
                                    });
                                },
                                close: function () {
                                    _self.dialog.$confirm.off('click');
                                }
                            }
                        });
                    });

            this.$addButton.on('click', function (e) {
                e.preventDefault();

                _self.rowAdd();
            });

            this.dialog.$cancel.on('click', function (e) {
                e.preventDefault();
                $.magnificPopup.close();
            });

            return this;
        },
        // ==========================================================================================
        // ROW FUNCTIONS
        // ==========================================================================================
        rowAdd: function () {
            this.$addButton.attr({'disabled': 'disabled'});

            var actions,
                    data,
                    $row;

            actions = [
                '<a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>',
                '<a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>',
                '<a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>',
                '<a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>'
            ].join(' ');

            data = this.datatable.row.add(['', '', '', actions]);
            $row = this.datatable.row(data[0]).nodes().to$();

            $row
                    .addClass('adding')
                    .find('td:last')
                    .addClass('actions');

            this.rowEdit($row);

            this.datatable.order([0, 'asc']).draw(); // always show fields
        },
        rowCancel: function ($row) {
            var _self = this,
                    $actions,
                    i,
                    data;

            if ($row.hasClass('adding')) {
                this.rowRemove($row);
            } else {

                data = this.datatable.row($row.get(0)).data();
                this.datatable.row($row.get(0)).data(data);

                $actions = $row.find('td.actions');
                if ($actions.get(0)) {
                    this.rowSetActionsDefault($row);
                }

                this.datatable.draw();
            }
        },
        rowEdit: function ($row) {
            var _self = this,
                    data;

            data = this.datatable.row($row.get(0)).data();

            $row.children('td').each(function (i) {
                var $this = $(this);

                if ($this.hasClass('actions')) {
                    _self.rowSetActionsEditing($row);
                }
                else if ($this.hasClass('actions')) {
                    _self.rowSetActionsEditing($row);
                } else {
                    $this.html('<input type="text" class="form-control input-block" value="' + data[i] + '"/>');
                }
            });
        },
        rowSave: function ($row) {
            var _self = this,
                    $actions,
                    values = [];

            if ($row.hasClass('adding')) {
                this.$addButton.removeAttr('disabled');
                $row.removeClass('adding');
            }

            values = $row.find('td').map(function () {
                var $this = $(this);

                if ($this.hasClass('actions')) {
                    _self.rowSetActionsDefault($row);
                    return _self.datatable.cell(this).data();
                } else {
                    return $.trim($this.find('input').val());
                }
            });

            this.datatable.row($row.get(0)).data(values);

            $actions = $row.find('td.actions');
            if ($actions.get(0)) {
                this.rowSetActionsDefault($row);
            }

            this.datatable.draw();
            var request = $.ajax({
                url: "/change",
                type: "POST",
                data: {
                    _token: values[0],
                    id: values[1],
                    attend: values[3],
                    break: values[5],
                    leave: values[6]
                },
                beforeSend: function () {
                }
            }).done(function (msg) {
                $('.calc' + msg['response']['id']).html(msg['response']['workTime']);
            });
        },
        rowRemove: function ($row) {
            var _self = this,
                    $actions,
                    values = [];

            if ($row.hasClass('adding')) {
                this.$addButton.removeAttr('disabled');
                $row.removeClass('adding');
            }

            values = $row.find('td').map(function () {
                var $this = $(this);

                if ($this.hasClass('hello')) {
                    return _self.datatable.cell(this).data();
                } else {
                    return _self.datatable.cell(this).data();
                }
            });

            this.datatable.row($row.get(0)).data(values);

            $actions = $row.find('td.actions');
            if ($actions.get(0)) {
                this.rowSetActionsDefault($row);
            }
            this.datatable.row($row.get(0)).remove().draw();

            console.log(values);
            var request = $.ajax({
                url: "/delete",
                type: "POST",
                data: {
                    _token: values[0],
                    id: values[1]
                },
                beforeSend: function () {
                }
            }).done(function (msg) {

            });

        },
        rowSetActionsEditing: function ($row) {
            $row.find('.on-editing').removeClass('hidden');
            $row.find('.on-default').addClass('hidden');
        },
        rowSetActionsDefault: function ($row) {
            $row.find('.on-editing').addClass('hidden');
            $row.find('.on-default').removeClass('hidden');
        }

    };
    var EditableTable2 = {
        options: {
            addButton: '#addToTable',
            table: '.nameit2',
            dialog: {
                wrapper: '#dialog',
                cancelButton: '#dialogCancel',
                confirmButton: '#dialogConfirm',
            }
        },
        initialize: function () {
            this
                    .setVars()
                    .build()
                    .events();
        },
        setVars: function () {
            this.$table = $(this.options.table);
            this.$addButton = $(this.options.addButton);

            // dialog
            this.dialog = {};
            this.dialog.$wrapper = $(this.options.dialog.wrapper);
            this.dialog.$cancel = $(this.options.dialog.cancelButton);
            this.dialog.$confirm = $(this.options.dialog.confirmButton);

            return this;
        },
        build: function () {
            this.datatable = this.$table.DataTable({
                aoColumns: [
                    {"bSortable": false},
                    {"bSortable": false},
                    null,
                    null,
                    null,
                    null,
                    null,
                    {"bSortable": false}
                ]
            });

            window.dt = this.datatable;

            return this;
        },
        events: function () {
            var _self = this;

            this.$table
                    .on('click', 'a.save-row', function (e) {
                        e.preventDefault();
                        _self.rowSave($(this).closest('tr'));
                    })
                    .on('click', 'a.cancel-row', function (e) {
                        e.preventDefault();

                        _self.rowCancel($(this).closest('tr'));
                    })
                    .on('click', 'a.edit-row', function (e) {
                        e.preventDefault();

                        _self.rowEdit($(this).closest('tr'));
                    })
                    .on('click', 'a.remove-row', function (e) {
                        e.preventDefault();

                        var $row = $(this).closest('tr');

                        $.magnificPopup.open({
                            items: {
                                src: _self.options.dialog.wrapper,
                                type: 'inline'
                            },
                            preloader: false,
                            modal: true,
                            callbacks: {
                                change: function () {
                                    _self.dialog.$confirm.on('click', function (e) {
                                        e.preventDefault();

                                        _self.rowRemove($row);
                                        $.magnificPopup.close();
                                    });
                                },
                                close: function () {
                                    _self.dialog.$confirm.off('click');
                                }
                            }
                        });
                    });

            this.$addButton.on('click', function (e) {
                e.preventDefault();

                _self.rowAdd();
            });

            this.dialog.$cancel.on('click', function (e) {
                e.preventDefault();
                $.magnificPopup.close();
            });

            return this;
        },
        // ==========================================================================================
        // ROW FUNCTIONS
        // ==========================================================================================
        rowAdd: function () {
            this.$addButton.attr({'disabled': 'disabled'});

            var actions,
                    data,
                    $row;

            actions = [
                '<a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>',
                '<a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>',
                '<a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>',
                '<a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>'
            ].join(' ');

            data = this.datatable.row.add(['', '', '', actions]);
            $row = this.datatable.row(data[0]).nodes().to$();

            $row
                    .addClass('adding')
                    .find('td:last')
                    .addClass('actions');

            this.rowEdit($row);

            this.datatable.order([0, 'asc']).draw(); // always show fields
        },
        rowCancel: function ($row) {
            var _self = this,
                    $actions,
                    i,
                    data;

            if ($row.hasClass('adding')) {
                this.rowRemove($row);
            } else {

                data = this.datatable.row($row.get(0)).data();
                this.datatable.row($row.get(0)).data(data);

                $actions = $row.find('td.actions');
                if ($actions.get(0)) {
                    this.rowSetActionsDefault($row);
                }

                this.datatable.draw();
            }
        },
        rowEdit: function ($row) {
            var _self = this,
                    data;

            data = this.datatable.row($row.get(0)).data();

            $row.children('td').each(function (i) {
                var $this = $(this);

                if ($this.hasClass('actions')) {
                    _self.rowSetActionsEditing($row);
                }
                else if ($this.hasClass('actions')) {
                    _self.rowSetActionsEditing($row);
                } else {
                    $this.html('<input type="text" class="form-control input-block" value="' + data[i] + '"/>');
                }
            });

        }, rowSave: function ($row) {
            var _self = this,
                    $actions,
                    values = [];

            if ($row.hasClass('adding')) {
                this.$addButton.removeAttr('disabled');
                $row.removeClass('adding');
            }

            values = $row.find('td').map(function () {
                var $this = $(this);

                if ($this.hasClass('actions')) {
                    _self.rowSetActionsDefault($row);
                    return _self.datatable.cell(this).data();
                } else {
                    return $.trim($this.find('input').val());
                }
            });

            this.datatable.row($row.get(0)).data(values);

            $actions = $row.find('td.actions');
            if ($actions.get(0)) {
                this.rowSetActionsDefault($row);
            }

            this.datatable.draw();

            var request = $.ajax({
                url: "/changeExtra",
                type: "POST",
                data: {
                    _token: values[0],
                    id: values[1],
                    extra: values[3],
                    leave: values[6],
                    status: values[4]
                },
                beforeSend: function () {
                }
            }).done(function (msg) {
                $('.calc' + msg['extra']['id']).html(msg['extra']['workTime']);
            });
        },
        rowRemove: function ($row) {
            var _self = this,
                    $actions,
                    values = [];

            if ($row.hasClass('adding')) {
                this.$addButton.removeAttr('disabled');
                $row.removeClass('adding');
            }

            values = $row.find('td').map(function () {
                var $this = $(this);

                if ($this.hasClass('hello')) {
                    return _self.datatable.cell(this).data();
                } else {
                    return _self.datatable.cell(this).data();
                }
            });

            this.datatable.row($row.get(0)).data(values);

            $actions = $row.find('td.actions');
            if ($actions.get(0)) {
                this.rowSetActionsDefault($row);
            }
            this.datatable.row($row.get(0)).remove().draw();

            console.log(values);
            var request = $.ajax({
                url: "/deleteExtra",
                type: "POST",
                data: {
                    _token: values[0],
                    id: values[1]
                },
                beforeSend: function () {
                }
            }).done(function (msg) {

            });
        },
        rowSetActionsEditing: function ($row) {
            $row.find('.on-editing').removeClass('hidden');
            $row.find('.on-default').addClass('hidden');
        },
        rowSetActionsDefault: function ($row) {
            $row.find('.on-editing').addClass('hidden');
            $row.find('.on-default').removeClass('hidden');
        }

    };
    var EditableTable3 = {
        options: {
            addButton: '#addToTable',
            table: '.nameit3',
            dialog: {
                wrapper: '#dialog',
                cancelButton: '#dialogCancel',
                confirmButton: '#dialogConfirm',
            }
        },
        initialize: function () {
            this
                    .setVars()
                    .build()
                    .events();
        },
        setVars: function () {
            this.$table = $(this.options.table);
            this.$addButton = $(this.options.addButton);

            // dialog
            this.dialog = {};
            this.dialog.$wrapper = $(this.options.dialog.wrapper);
            this.dialog.$cancel = $(this.options.dialog.cancelButton);
            this.dialog.$confirm = $(this.options.dialog.confirmButton);

            return this;
        },
        build: function () {
            this.datatable = this.$table.DataTable({
                aoColumns: [
                    {"bSortable": false},
                    {"bSortable": false},
                    null,
                    null,
                    null,
                    null,
                    {"bSortable": false},
                    {"bSortable": false}
                ]
            });

            window.dt = this.datatable;

            return this;
        },
        events: function () {
            var _self = this;

            this.$table
                    .on('click', 'a.save-row', function (e) {
                        e.preventDefault();
                        _self.rowSave($(this).closest('tr'));
                    })
                    .on('click', 'a.cancel-row', function (e) {
                        e.preventDefault();

                        _self.rowCancel($(this).closest('tr'));
                    })
                    .on('click', 'a.edit-row', function (e) {
                        e.preventDefault();

                        _self.rowEdit($(this).closest('tr'));
                    })
                    .on('click', 'a.remove-row', function (e) {
                        e.preventDefault();

                        var $row = $(this).closest('tr');

                        $.magnificPopup.open({
                            items: {
                                src: _self.options.dialog.wrapper,
                                type: 'inline'
                            },
                            preloader: false,
                            modal: true,
                            callbacks: {
                                change: function () {
                                    _self.dialog.$confirm.on('click', function (e) {
                                        e.preventDefault();

                                        _self.rowRemove($row);
                                        $.magnificPopup.close();
                                    });
                                },
                                close: function () {
                                    _self.dialog.$confirm.off('click');
                                }
                            }
                        });
                    });

            this.$addButton.on('click', function (e) {
                e.preventDefault();

                _self.rowAdd();
            });

            this.dialog.$cancel.on('click', function (e) {
                e.preventDefault();
                $.magnificPopup.close();
            });

            return this;
        },
        // ==========================================================================================
        // ROW FUNCTIONS
        // ==========================================================================================
        rowAdd: function () {
            this.$addButton.attr({'disabled': 'disabled'});

            var actions,
                    data,
                    $row;

            actions = [
                '<a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>',
                '<a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>',
                '<a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>',
                '<a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>'
            ].join(' ');

            data = this.datatable.row.add(['', '', '', actions]);
            $row = this.datatable.row(data[0]).nodes().to$();

            $row
                    .addClass('adding')
                    .find('td:last')
                    .addClass('actions');

            this.rowEdit($row);

            this.datatable.order([0, 'asc']).draw(); // always show fields
        },
        rowCancel: function ($row) {
            var _self = this,
                    $actions,
                    i,
                    data;

            if ($row.hasClass('adding')) {
                this.rowRemove($row);
            } else {

                data = this.datatable.row($row.get(0)).data();
                this.datatable.row($row.get(0)).data(data);

                $actions = $row.find('td.actions');
                if ($actions.get(0)) {
                    this.rowSetActionsDefault($row);
                }

                this.datatable.draw();
            }
        },
        rowEdit: function ($row) {
            var _self = this,
                    data;

            data = this.datatable.row($row.get(0)).data();

            $row.children('td').each(function (i) {
                var $this = $(this);

                if ($this.hasClass('actions')) {
                    _self.rowSetActionsEditing($row);
                }
                else if ($this.hasClass('actions')) {
                    _self.rowSetActionsEditing($row);
                } else {
                    $this.html('<input type="text" class="form-control input-block" value="' + data[i] + '"/>');
                }
            });

        }, rowSave: function ($row) {
            var _self = this,
                    $actions,
                    values = [];

            if ($row.hasClass('adding')) {
                this.$addButton.removeAttr('disabled');
                $row.removeClass('adding');
            }

            values = $row.find('td').map(function () {
                var $this = $(this);

                if ($this.hasClass('actions')) {
                    _self.rowSetActionsDefault($row);
                    return _self.datatable.cell(this).data();
                } else {
                    return $.trim($this.find('input').val());
                }
            });

            this.datatable.row($row.get(0)).data(values);

            $actions = $row.find('td.actions');
            if ($actions.get(0)) {
                this.rowSetActionsDefault($row);
            }

            this.datatable.draw();
            console.log(values);
            var request = $.ajax({
                url: "/control",
                type: "POST",
                data: {
                    _token: values[0],
                    id: values[1],
                    name: values[2],
                    shift: values[3],
                    role: values[4],
                    email: values[5],
                    password: values[6]
                },
                beforeSend: function () {
                }
            }).done(function (msg) {
               alert('hello');
            });
        },
        rowRemove: function ($row) {
            var _self = this,
                    $actions,
                    values = [];

            if ($row.hasClass('adding')) {
                this.$addButton.removeAttr('disabled');
                $row.removeClass('adding');
            }

            values = $row.find('td').map(function () {
                var $this = $(this);

                if ($this.hasClass('hello')) {
                    return _self.datatable.cell(this).data();
                } else {
                    return _self.datatable.cell(this).data();
                }
            });

            this.datatable.row($row.get(0)).data(values);

            $actions = $row.find('td.actions');
            if ($actions.get(0)) {
                this.rowSetActionsDefault($row);
            }
            this.datatable.row($row.get(0)).remove().draw();

            console.log(values);
            var request = $.ajax({
                url: "/userDelete",
                type: "POST",
                data: {
                    _token: values[0],
                    id: values[1]
                },
                beforeSend: function () {
                }
            }).done(function (msg) {

            });
        },
        rowSetActionsEditing: function ($row) {
            $row.find('.on-editing').removeClass('hidden');
            $row.find('.on-default').addClass('hidden');
        },
        rowSetActionsDefault: function ($row) {
            $row.find('.on-editing').addClass('hidden');
            $row.find('.on-default').removeClass('hidden');
        }

    };

    var EditableTable4 = {
        options: {
            addButton: '#addToTable',
            table: '.nameit4',
            dialog: {
                wrapper: '#dialog',
                cancelButton: '#dialogCancel',
                confirmButton: '#dialogConfirm',
            }
        },
        initialize: function () {
            this
                    .setVars()
                    .build()
                    .events();
        },
        setVars: function () {
            this.$table = $(this.options.table);
            this.$addButton = $(this.options.addButton);

            // dialog
            this.dialog = {};
            this.dialog.$wrapper = $(this.options.dialog.wrapper);
            this.dialog.$cancel = $(this.options.dialog.cancelButton);
            this.dialog.$confirm = $(this.options.dialog.confirmButton);

            return this;
        },
        build: function () {
            this.datatable = this.$table.DataTable({
                aoColumns: [
                    {"bSortable": false},
                    {"bSortable": false},
                    null,
                    null,
                    null,
                    {"bSortable": false},
                    {"bSortable": false}
                ]
            });

            window.dt = this.datatable;

            return this;
        },
        events: function () {
            var _self = this;

            this.$table
                    .on('click', 'a.save-row', function (e) {
                        e.preventDefault();
                        _self.rowSave($(this).closest('tr'));
                    })
                    .on('click', 'a.cancel-row', function (e) {
                        e.preventDefault();

                        _self.rowCancel($(this).closest('tr'));
                    })
                    .on('click', 'a.edit-row', function (e) {
                        e.preventDefault();

                        _self.rowEdit($(this).closest('tr'));
                    })
                    .on('click', 'a.remove-row', function (e) {
                        e.preventDefault();

                        var $row = $(this).closest('tr');

                        $.magnificPopup.open({
                            items: {
                                src: _self.options.dialog.wrapper,
                                type: 'inline'
                            },
                            preloader: false,
                            modal: true,
                            callbacks: {
                                change: function () {
                                    _self.dialog.$confirm.on('click', function (e) {
                                        e.preventDefault();

                                        _self.rowRemove($row);
                                        $.magnificPopup.close();
                                    });
                                },
                                close: function () {
                                    _self.dialog.$confirm.off('click');
                                }
                            }
                        });
                    });

            this.$addButton.on('click', function (e) {
                e.preventDefault();

                _self.rowAdd();
            });

            this.dialog.$cancel.on('click', function (e) {
                e.preventDefault();
                $.magnificPopup.close();
            });

            return this;
        },
        // ==========================================================================================
        // ROW FUNCTIONS
        // ==========================================================================================
        rowAdd: function () {
            this.$addButton.attr({'disabled': 'disabled'});

            var actions,
                    data,
                    $row;

            actions = [
                '<a href="#" class="hidden on-editing save-row"><i class="fa fa-save"></i></a>',
                '<a href="#" class="hidden on-editing cancel-row"><i class="fa fa-times"></i></a>',
                '<a href="#" class="on-default edit-row"><i class="fa fa-pencil"></i></a>',
                '<a href="#" class="on-default remove-row"><i class="fa fa-trash-o"></i></a>'
            ].join(' ');

            data = this.datatable.row.add(['', '', '', actions]);
            $row = this.datatable.row(data[0]).nodes().to$();

            $row
                    .addClass('adding')
                    .find('td:last')
                    .addClass('actions');

            this.rowEdit($row);

            this.datatable.order([0, 'asc']).draw(); // always show fields
        },
        rowCancel: function ($row) {
            var _self = this,
                    $actions,
                    i,
                    data;

            if ($row.hasClass('adding')) {
                this.rowRemove($row);
            } else {

                data = this.datatable.row($row.get(0)).data();
                this.datatable.row($row.get(0)).data(data);

                $actions = $row.find('td.actions');
                if ($actions.get(0)) {
                    this.rowSetActionsDefault($row);
                }

                this.datatable.draw();
            }
        },
        rowEdit: function ($row) {
            var _self = this,
                    data;

            data = this.datatable.row($row.get(0)).data();

            $row.children('td').each(function (i) {
                var $this = $(this);

                if ($this.hasClass('actions')) {
                    _self.rowSetActionsEditing($row);
                }
                else if ($this.hasClass('actions')) {
                    _self.rowSetActionsEditing($row);
                } else {
                    $this.html('<input type="text" class="form-control input-block" value="' + data[i] + '"/>');
                }
            });

        }, rowSave: function ($row) {
            var _self = this,
                    $actions,
                    values = [];

            if ($row.hasClass('adding')) {
                this.$addButton.removeAttr('disabled');
                $row.removeClass('adding');
            }

            values = $row.find('td').map(function () {
                var $this = $(this);

                if ($this.hasClass('actions')) {
                    _self.rowSetActionsDefault($row);
                    return _self.datatable.cell(this).data();
                } else {
                    return $.trim($this.find('input').val());
                }
            });

            this.datatable.row($row.get(0)).data(values);

            $actions = $row.find('td.actions');
            if ($actions.get(0)) {
                this.rowSetActionsDefault($row);
            }

            this.datatable.draw();

            var request = $.ajax({
                url: "/hoursChange",
                type: "POST",
                data: {
                    _token: values[0],
                    id: values[1],
                    first: values[2],
                    firstEnd: values[3],
                    second: values[4],
                    secondEnd: values[5]
                },
                beforeSend: function () {
                }
            }).done(function (msg) {
                alert('hours');
            });
        },
        rowRemove: function ($row) {
            var _self = this,
                    $actions,
                    values = [];

            if ($row.hasClass('adding')) {
                this.$addButton.removeAttr('disabled');
                $row.removeClass('adding');
            }

            values = $row.find('td').map(function () {
                var $this = $(this);

                if ($this.hasClass('hello')) {
                    return _self.datatable.cell(this).data();
                } else {
                    return _self.datatable.cell(this).data();
                }
            });

            this.datatable.row($row.get(0)).data(values);

            $actions = $row.find('td.actions');
            if ($actions.get(0)) {
                this.rowSetActionsDefault($row);
            }
            this.datatable.row($row.get(0)).remove().draw();

            console.log(values);
            var request = $.ajax({
                url: "/deleteExtra",
                type: "POST",
                data: {
                    _token: values[0],
                    id: values[1]
                },
                beforeSend: function () {
                }
            }).done(function (msg) {

            });
        },
        rowSetActionsEditing: function ($row) {
            $row.find('.on-editing').removeClass('hidden');
            $row.find('.on-default').addClass('hidden');
        },
        rowSetActionsDefault: function ($row) {
            $row.find('.on-editing').addClass('hidden');
            $row.find('.on-default').removeClass('hidden');
        }

    };


    $(function () {
        EditableTable.initialize();
        EditableTable2.initialize();
        EditableTable3.initialize();
        EditableTable4.initialize();
    });

}).apply(this, [jQuery]);