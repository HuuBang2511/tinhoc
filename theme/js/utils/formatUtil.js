export function replaceProperties(string, properties) {
  const keys = Object.keys(properties);
  for (let key of keys) {
    string = string.replace(`{${key}}`, properties[key]);
  }
  return string;
}
