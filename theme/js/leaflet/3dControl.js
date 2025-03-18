L.Control.Btn3D = L.Control.extend({
    onAdd: function (map) {
        var div = L.DomUtil.create('div')
        L.DomUtil.addClass(div, 'leaflet-bar')
        var a = L.DomUtil.create('a');

        a.id = 'btn-3d';
        a.title = "Xem ở chế độ 3D"
        L.DomUtil.addClass(a, 'btn btn-icon')
        L.DomEvent.on(div, 'click', this.options.onClick)
        div.append(a)
        return div;
    },


});

L.control.btn3D = function (opts) {
    return new L.Control.Btn3D(opts);
}