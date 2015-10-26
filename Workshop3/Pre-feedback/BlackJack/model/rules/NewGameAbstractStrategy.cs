using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model.rules
{
    abstract class NewGameAbstractStrategy : INewGameStrategy
    {
        public abstract bool NewGame(Deck a_deck, Dealer a_dealer, Player a_player);

        protected void DealCard(Deck a_deck, Player a_player, bool show = true)
        {
            Card c;

            c = a_deck.GetCard();
            c.Show(show);
            a_player.DealCard(c);
        }
    }
}
