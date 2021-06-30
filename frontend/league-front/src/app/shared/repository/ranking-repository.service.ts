import { Injectable } from '@angular/core';
import { Observer, Observable, of } from 'rxjs';
import { map } from 'rxjs/operators';
import { GeneralRanking, GetGeneralRankingResponse } from '../model/general_ranking';
import { FacadeService } from '../service/facade.service';


@Injectable({
  providedIn: 'root'
})
export class RankingRepositoryService {

  private initialized: boolean = false;
  public GeneralRankings: GeneralRanking[] = [];
  private generalRankingObserver: Observable<GeneralRanking[]>;

  constructor(private facade: FacadeService) {
    this.generalRankingObserver = Observable.create((observer: Observer<GeneralRanking[]>) => {
      this.GeneralRankings = [];
      this.facade.GetGeneralRankingJson().pipe(map(res => res)).subscribe( value => {
        this.GeneralRankings = value;
        observer.next(value);
        observer.complete();
        this.initialized = true;
      } 
      );
    });
   }

  public Initialize(): Observable<GeneralRanking[]>{
    if(this.initialized) return of(this.GeneralRankings);
    return this.Get();
  }

  public Get(): Observable<GeneralRanking[]> {
    if(!this.initialized)
      return this.Refresh();
    return of(this.GeneralRankings);
  }

  public Refresh(): Observable<GeneralRanking[]> {
    return this.generalRankingObserver;
  }
}
