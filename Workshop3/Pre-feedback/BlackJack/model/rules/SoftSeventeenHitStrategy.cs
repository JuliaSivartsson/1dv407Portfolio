using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model.rules
{
    class SoftSeventeenHitStrategy : IHitStrategy
    {
        private const int g_hitLimit = 17;

        public bool DoHit(model.Player a_dealer)
        {
            if(a_dealer.CalcScore() == g_hitLimit)
            {
                var aces = a_dealer.GetHand().Where(c => c.GetValue() == Card.Value.Ace);
                var other = a_dealer.GetHand().Where(c => c.GetValue() != Card.Value.Ace);

                int score = a_dealer.CalcScoreOfCards(other);

                return aces.Count() > 0 && score == 6;
            }

            return a_dealer.CalcScore() < g_hitLimit;            
        }
    }
}
