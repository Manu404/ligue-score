import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class LoadingService {
  
  IsLoading: boolean = false;

  constructor() { }
}
