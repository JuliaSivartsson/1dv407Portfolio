﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model.rules
{
    class BasicWinStrategy : IWinStrategy
    {
        public bool IsWinner(Dealer a_dealer, Player a_player, int g_maxScore)
        {
            if (a_player.CalcScore() > g_maxScore)
            {
                return true;
            }
            else if (a_dealer.CalcScore() > g_maxScore)
            {
                return false;
            }
            return a_dealer.CalcScore() > a_player.CalcScore();
        }
    }
}
