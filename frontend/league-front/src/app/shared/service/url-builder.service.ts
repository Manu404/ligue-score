import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UrlBuilderService {

  constructor() { }

  private GetBaseUrl() : string {
    return "https://backend.edhleague.be/index.php/api/v1"
  }

  public BuildUrl(target:string) : string{
    return this.GetBaseUrl() + target;
  }
}
