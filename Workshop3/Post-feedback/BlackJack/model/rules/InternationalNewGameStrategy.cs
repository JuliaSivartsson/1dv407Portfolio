using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model.rules
{
    class InternationalNewGameStrategy : NewGameAbstractStrategy
    {

        override public bool NewGame(Deck a_deck, Dealer a_dealer, Player a_player)
        {
            DealCard(a_deck, a_player);
            DealCard(a_deck, a_dealer);
            DealCard(a_deck, a_player);

            return true;
        }
    }
}
