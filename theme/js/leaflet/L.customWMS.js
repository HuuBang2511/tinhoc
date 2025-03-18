L.tileLayer.wms = function (url, options) {
  const defaultOptions = {
    format: "image/png",
    transparent: true,
  };
  return new L.TileLayer.WMS(url, { ...defaultOptions, ...options });
};
