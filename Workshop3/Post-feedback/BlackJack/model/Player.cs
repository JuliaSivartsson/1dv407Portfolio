using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace BlackJack.model
{
    class Player
    {
        private List<Card> m_hand = new List<Card>();
        private List<CardObserver> m_subscribers = new List<CardObserver>();

        public void DealCard(Card a_card)
        {
            foreach (CardObserver observer in m_subscribers)
            {
                observer.CardDealt();
            }
            m_hand.Add(a_card);
        }

        public void AddSubscriber(CardObserver observer)
        {
            m_subscribers.Add(observer);
        }

        public IEnumerable<Card> GetHand()
        {
            return m_hand.Cast<Card>();
        }

        public void ClearHand()
        {
            m_hand.Clear();
        }

        public void ShowHand()
        {
            foreach (Card c in GetHand())
            {
                c.Show(true);
            }
        }

        public int CalcScore()
        {
            int score = CalcScoreOfCards(GetHand());
            if (score > 21)
            {
                foreach (Card c in GetHand())
                {
                    if (c.GetValue() == Card.Value.Ace && score > 21)
                    {
                        score -= 10;
                    }
                }
            }

            return score;
        }

        public int CalcScoreOfCards(IEnumerable<Card> a_hand)
        {
            int[] cardScores = new int[(int)model.Card.Value.Count]
                {2, 3, 4, 5, 6, 7, 8, 9, 10, 10 ,10 ,10, 11};
            int score = 0;

            foreach (Card c in a_hand)
            {
                if (c.GetValue() != Card.Value.Hidden)
                {
                    score += cardScores[(int)c.GetValue()];
                }
            }

            return score;
        }
    }
}
