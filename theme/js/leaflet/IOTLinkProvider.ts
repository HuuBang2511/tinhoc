import AbstractProvider, {
  EndpointArgument,
  LatLng,
  ParseArgument,
  SearchResult,
} from "leaflet-geosearch/src/providers/provider";

export interface RequestResult {
  result: RawResult[];
}

export interface RawResult {
  id: string;
  name: string;
  address: string;
  location: LatLng;
}

export default class IOTLinkProvider extends AbstractProvider<
  RequestResult,
  RawResult
> {
  searchUrl = "http://api.map4d.vn/sdk/autosuggest";

  endpoint({ query }: EndpointArgument): string {
    const params = typeof query === "string" ? { text: query } : query;
    return this.getUrl(this.searchUrl, params);
  }

  parse(response: ParseArgument<RequestResult>): SearchResult<RawResult>[] {
    return response.data.result
      .filter((r) => r.location !== undefined)
      .map((r) => ({
        x: r.location.lng,
        y: r.location.lat,
        label: r.address,
        bounds: null,
        raw: r,
      }));
  }
}
