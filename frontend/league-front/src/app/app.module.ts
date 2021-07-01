import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import { MatSliderModule } from '@angular/material/slider';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatTableModule } from '@angular/material/table';
import { MatListModule } from '@angular/material/list';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatSortModule } from '@angular/material/sort';

import { FontAwesomeModule } from '@fortawesome/angular-fontawesome';

import { AppComponent } from './app.component';
import { HomeComponent } from './ui/home/home.component';
import { MenuComponent } from './ui/menu/menu.component';
import { AppRoutingModule } from './app-routing.module';
import { InfosComponent } from './ui/infos/infos.component';
import { MatchListComponent } from './ui/match-list/match-list.component';
import { StatsComponent } from './ui/stats/stats.component';
import { ContactComponent } from './ui/contact/contact.component';
import { GameDetailComponent } from './ui/game-detail/game-detail.component';
import { PlayerComponent } from './ui/player/player.component';
import { LeaderboardComponent } from './ui/leaderboard/leaderboard.component';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    MenuComponent,
    InfosComponent,
    MatchListComponent,
    StatsComponent,
    ContactComponent,
    GameDetailComponent,
    PlayerComponent,
    LeaderboardComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule,
    BrowserAnimationsModule,
    MatSliderModule,
    MatSidenavModule,
    MatTableModule,
    MatListModule,
    MatIconModule,
    MatButtonModule,
    MatProgressSpinnerModule,
    FontAwesomeModule,
    MatSortModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
