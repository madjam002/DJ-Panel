$(function() {
    $("#playlist-manager").load(Routing.generate("dj_panel_auto_dj_playlist_list"));
});


/*var TreeDataSource = function (options) {
    this._data = options.data;
    this._delay = options.delay;
};

TreeDataSource.prototype = {

    data: function (options, callback) {
        var self = this;

        setTimeout(function () {
            var data = $.extend(true, [], self._data);

            callback({
                data: data
            });

        }, this._delay)
    }

};


var treeDataSource = new TreeDataSource({
    data: [
    {
        name: 'Test Folder 1',
        type: 'folder',
        additionalParameters: {
            id: 'F1'
        }
    },
{
    name: 'Test Folder 2',
    type: 'folder',
    additionalParameters: {
        id: 'F2'
    }
},
{
    name: 'Test Item 1',
    type: 'item',
    additionalParameters: {
        id: 'I1'
    }
},
{
    name: 'Test Item 2',
    type: 'item',
    additionalParameters: {
        id: 'I2'
    }
}
],
delay: 400
});

$('#MyTree').tree({
    dataSource: treeDataSource
});
*/