using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using BlackJack.view;
using BlackJack.model;

namespace BlackJack.controller
{
    class PlayGame : model.CardObserver
    {

        public PlayGame(model.Game a_game, view.IView a_view)
        {
            m_game = a_game;
            m_view = a_view;
            m_game.DealNewCard(this);
        }

        private IView m_view;
        private model.Game m_game;

        public enum Action
        {
            Hit,
            Stand,
            NewGame,
            Quit,
            Undefined
        }

        public bool Play()
        {
            ShowGame();

            if (m_game.IsGameOver())
            {
                m_view.DisplayGameOver(m_game.IsDealerWinner());
            }

            PlayGame.Action input = m_view.GetInput();

            if (input == Action.NewGame)
            {
                m_game.NewGame();
            }
            else if (input == Action.Hit)
            {
                m_game.Hit();
            }
            else if (input == Action.Stand)
            {
                m_game.Stand();
            }

            return input != Action.Quit;
        }

        private void ShowGame()
        {

            m_view.DisplayWelcomeMessage();

            m_view.DisplayDealerHand(m_game.GetDealerHand(), m_game.GetDealerScore());
            m_view.DisplayPlayerHand(m_game.GetPlayerHand(), m_game.GetPlayerScore());
        } 

        public void CardDealt(Player player, Card card)
        {
            m_view.Pause(1000);
            ShowGame();
        }
    }
}
