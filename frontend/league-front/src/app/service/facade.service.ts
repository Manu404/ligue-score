import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { GeneralRanking, GetGeneralRankingResponse } from '../model/general_ranking';

@Injectable({
  providedIn: 'root'
})
export class FacadeService {

  constructor(private http: HttpClient) { }

  public GetGeneralRankingJson() : Observable<GeneralRanking[]> {
    return this.http.get<GetGeneralRankingResponse>("http://localhost/index.php/api/v1/ranking/general/").pipe( map( response => response.result ));;
  }
}
