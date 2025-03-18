L.Control.Legend = L.Control.extend({
  options: {
    position: "bottomleft",
  },
  onAdd: function (map) {
    var container = L.DomUtil.create(
      "div",
      "leaflet-bar leaflet-control leaflet-control-legend p-2 bg-white"
    );
    container.innerHTML = this.options.content ?? "Legend";
    return container;
  },
});

L.control.legend = function (options) {
  return new L.Control.Legend(options);
};
