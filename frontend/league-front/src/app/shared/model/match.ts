export interface MatchSummary {
    gameid: number;
    playerid: number;
    total: number
}

export interface MatchSummaryResponse {
    status: number;
    message: string;
    result: MatchSummary[];
}