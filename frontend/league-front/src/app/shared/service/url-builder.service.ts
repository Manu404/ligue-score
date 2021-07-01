import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UrlBuilderService {
  localhostDevUrl: string = "http://localhost/index.php/api/v1";
  productionUrl: string = "https://backend.edhleague.be/index.php/api/v1";

  constructor() { }

  private GetBaseUrl() : string {
    return this.productionUrl;
  }

  public BuildUrl(target:string) : string{
    return this.GetBaseUrl() + target;
  }
}
