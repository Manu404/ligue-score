import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { Catalog, GetCatalogResponse } from '../model/catalog';
import { GeneralRanking, GetGeneralRankingResponse } from '../model/general_ranking';
import { UrlBuilderService } from './url-builder.service';

@Injectable({
  providedIn: 'root'
})
export class FacadeService {

  constructor(private http: HttpClient, private urlBuilder: UrlBuilderService) { }

  public GetGeneralRankingJson() : Observable<GeneralRanking[]> {
    console.log("getGeneralRanking");
    return this.http.get<GetGeneralRankingResponse>(this.urlBuilder.BuildUrl("/ranking/general/")).pipe( map( response => response.result ));;
  }

  public GetCatalog() : Observable<Catalog> {
    console.log("getCatalog");
    return this.http.get<GetCatalogResponse>(this.urlBuilder.BuildUrl("/catalog/")).pipe( map( response => response.result ));;
  }
}
