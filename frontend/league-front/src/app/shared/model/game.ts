export interface GameSummary {
    gameid: number;
    playerid: number;
    total: number;
}

export interface Game {
    id: number;
    type: number;
    dayid: number;
}

export interface GetGamesResponse {
    status: number;
    message: string;
    result: Game[];
}

export interface GamesSummaryResponse {
    status: number;
    message: string;
    result: GameSummary[];
}