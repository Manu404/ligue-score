import { Injectable } from '@angular/core';
import { of } from 'rxjs';
import { Observable, Observer } from 'rxjs';
import { map } from 'rxjs/operators';
import { Catalog } from '../model/catalog';
import { MatchSummary } from '../model/match';
import { FacadeService } from '../service/facade.service';


@Injectable({
  providedIn: 'root'
})
export class MatchRepositoryService {

  private initialized: boolean = false;
  public MatchSummary: MatchSummary[] = [];
  private catalogObserver: Observable<MatchSummary[]>;

  constructor(private facade: FacadeService) { 
    this.catalogObserver = Observable.create((observer: Observer<MatchSummary[]>) => {
      this.MatchSummary = [];
      this.facade.GetMatchSummary().pipe(map(res => res)).subscribe( value => {
        this.MatchSummary = value;
        observer.next(value);
        observer.complete();
        this.initialized = true;
      });
    });
  }

  public Initialize(): Observable<MatchSummary[]>{
    if(this.initialized) return of(this.MatchSummary);
    return this.GetMatchSummary();
  }

  public GetMatchSummary(): Observable<MatchSummary[]> {
    if(!this.initialized)
      return this.RefreshMatchSummary();
    return of(this.MatchSummary);
  }

  public RefreshMatchSummary(): Observable<MatchSummary[]> {
    return this.catalogObserver;
  }
}
