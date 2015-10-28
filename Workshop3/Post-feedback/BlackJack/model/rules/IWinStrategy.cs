using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model.rules
{
    interface IWinStrategy
    {
        bool IsWinner( Dealer a_dealer, Player a_player, int g_maxScore);
    }
}
